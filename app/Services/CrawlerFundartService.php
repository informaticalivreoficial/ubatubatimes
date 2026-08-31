<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostGb;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class CrawlerFundartService
{
    private const BASE_URL = 'https://fundart.com.br';

    private const LISTING_URL = self::BASE_URL . '/noticias';

    private const AUTHOR_ID = 1;

    private const CAT_PAI = 56;

    private const CATEGORY = 73;

    public function run(): void
    {
        $client = HttpClient::create([
            'timeout' => 30,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (compatible; UbatubaTimes/1.0)',
            ],
        ]);

        $manager = new ImageManager(new Driver());

        try {
            $response = $client->request('GET', self::LISTING_URL);
            $crawler = new Crawler($response->getContent());
            $item = $crawler->filter('.archive-posts article.list-post')->first();

            if (! $item->count()) {
                Log::warning('CrawlerFundart: nenhuma notícia encontrada');

                return;
            }

            $this->processItem($item, $client, $manager);
        } catch (Throwable $exception) {
            Log::error('CrawlerFundart: erro geral', [
                'erro' => $exception->getMessage(),
            ]);
        }
    }

    private function processItem(Crawler $item, HttpClientInterface $client, ImageManager $manager): void
    {
        $titleNode = $item->filter('h2.list-post-title');

        if ($titleNode->count() === 0) {
            return;
        }

        $title = trim($titleNode->text());
        $slug = Str::slug($title);
        $link = $this->absoluteUrl($item->filter('a')->attr('href'));

        if ($title === '' || $link === null) {
            return;
        }

        if (Post::where('slug', $slug)->orWhere('title', $title)->exists()) {
            Log::info('CrawlerFundart: já existe', ['title' => $title]);

            return;
        }

        $content = $this->fetchContent($client, $link);

        if ($content === null) {
            return;
        }

        $post = Post::create([
            'type' => 'noticia',
            'autor' => self::AUTHOR_ID,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'cat_pai' => self::CAT_PAI,
            'category' => self::CATEGORY,
            'status' => 1,
            'publish_at' => $this->parsePublishDate($item),
        ]);

        $imageUrl = $this->extractImageFromArticle($client, $link);

        if ($imageUrl !== null) {
            $this->storeCover($client, $manager, $post, $imageUrl);
        }
    }

    private function fetchContent(HttpClientInterface $client, string $link): ?string
    {
        try {
            $response = $client->request('GET', $link);
            $crawler = new Crawler($response->getContent());
            $body = $crawler->filter('.single-content');

            if ($body->count() === 0) {
                Log::warning('CrawlerFundart: conteúdo não encontrado', [
                    'link' => $link,
                ]);

                return null;
            }

            $html = $body->html();
            $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html) ?? $html;
            $html = preg_replace('#<style\b[^>]*>.*?</style>#is', '', $html) ?? $html;

            return $html
                . '<br><br><small>Fonte: <a href="' . self::BASE_URL . '" target="_blank" rel="noopener">FundArt</a></small>';
        } catch (Throwable $exception) {
            Log::warning('CrawlerFundart: erro ao acessar conteúdo', [
                'link' => $link,
                'erro' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    private function extractImageFromArticle(HttpClientInterface $client, string $link): ?string
    {
        try {
            $response = $client->request('GET', $link);
            $crawler = new Crawler($response->getContent());
            $imgNode = $crawler->filter('.single-content img')->first();

            if (! $imgNode->count()) {
                return null;
            }

            $srcset = $imgNode->attr('srcset');

            if ($srcset) {
                $sources = explode(',', $srcset);
                $last = trim(end($sources));
                $img = explode(' ', $last)[0];
            } else {
                $img = $imgNode->attr('src') ?: $imgNode->attr('data-src');
            }

            return $this->absoluteUrl($img);
        } catch (Throwable) {
            return null;
        }
    }

    private function storeCover(
        HttpClientInterface $client,
        ImageManager $manager,
        Post $post,
        string $imageUrl
    ): void {
        try {
            $imageContent = $this->downloadImage($client, $imageUrl);

            if ($imageContent === null) {
                return;
            }

            $image = $manager->read($imageContent);
            $image->scaleDown(width: 1920);

            $path = 'posts/noticia/' . $post->id . '/' . Str::slug($post->title) . '.webp';

            Storage::disk('public')->put($path, (string) $image->toWebp(85));

            PostGb::create([
                'post' => $post->id,
                'cover' => true,
                'path' => $path,
            ]);
        } catch (Throwable $exception) {
            Log::warning('CrawlerFundart: erro ao baixar imagem', [
                'img' => $imageUrl,
                'erro' => $exception->getMessage(),
            ]);
        }
    }

    private function downloadImage(HttpClientInterface $client, string $imageUrl): ?string
    {
        try {
            return $client->request('GET', $imageUrl)->getContent();
        } catch (Throwable) {
            return null;
        }
    }

    private function parsePublishDate(Crawler $item): Carbon
    {
        $dateNode = $item->filter('.blog-item-details .date, .date.updated');

        if ($dateNode->count() > 0) {
            try {
                return Carbon::createFromFormat('d/m/Y', trim($dateNode->text()))->startOfDay();
            } catch (Throwable) {
                // usa a data atual
            }
        }

        return now();
    }

    private function absoluteUrl(?string $url): ?string
    {
        if ($url === null || trim($url) === '') {
            return null;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        return self::BASE_URL . '/' . ltrim($url, '/');
    }
}
