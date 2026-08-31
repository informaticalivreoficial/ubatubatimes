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

class CrawlerCaraguatatubaService
{
    private const BASE_URL = 'https://www.caraguatatuba.sp.gov.br';

    private const LISTING_URL = self::BASE_URL . '/pmc/';

    private const AUTHOR_ID = 1;

    private const CAT_PAI = 56;

    private const CATEGORY = 74;

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
            $items = $crawler->filter('#featuredNews .card');

            if ($items->count() === 0) {
                Log::warning('CrawlerCaraguatatuba: nenhuma notícia encontrada');

                return;
            }

            $items->each(function (Crawler $item) use ($client, $manager): void {
                try {
                    $this->processItem($item, $client, $manager);
                } catch (Throwable $exception) {
                    Log::warning('CrawlerCaraguatatuba: erro no item', [
                        'erro' => $exception->getMessage(),
                    ]);
                }
            });
        } catch (Throwable $exception) {
            Log::error('CrawlerCaraguatatuba: erro geral', [
                'erro' => $exception->getMessage(),
            ]);
        }
    }

    private function processItem(Crawler $item, HttpClientInterface $client, ImageManager $manager): void
    {
        $titleNode = $item->filter('h5.card-title a');

        if ($titleNode->count() === 0) {
            return;
        }

        $title = trim($titleNode->text());
        $link = $this->absoluteUrl($titleNode->attr('href'));
        $slug = Str::slug($title);

        if ($title === '' || $link === null) {
            return;
        }

        if (Post::where('slug', $slug)->orWhere('title', $title)->exists()) {
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

        $imageUrl = $this->extractListingImage($item);

        if ($imageUrl !== null) {
            $this->storeCover($client, $manager, $post, $imageUrl);
        }
    }

    private function fetchContent(HttpClientInterface $client, string $link): ?string
    {
        try {
            $response = $client->request('GET', $link);
            $crawler = new Crawler($response->getContent());
            $body = $crawler->filter('.card-text');

            if ($body->count() === 0) {
                Log::warning('CrawlerCaraguatatuba: conteúdo não encontrado', [
                    'link' => $link,
                ]);

                return null;
            }

            $html = $body->html();
            $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html) ?? $html;
            $html = preg_replace('#<style\b[^>]*>.*?</style>#is', '', $html) ?? $html;

            return $html
                . '<br><br><small>Fonte: <a href="' . self::BASE_URL . '/pmc/" target="_blank" rel="noopener">Prefeitura de Caraguatatuba</a></small>';
        } catch (Throwable $exception) {
            Log::warning('CrawlerCaraguatatuba: erro ao acessar conteúdo', [
                'link' => $link,
                'erro' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    private function extractListingImage(Crawler $item): ?string
    {
        $imgNode = $item->filter('img.card-img-top, img')->first();

        if ($imgNode->count() === 0) {
            return null;
        }

        $img = $imgNode->attr('src') ?: $imgNode->attr('data-src');
        $img = $this->absoluteUrl($img);

        if ($img === null) {
            return null;
        }

        return preg_replace('/-\d+x\d+(?=\.\w+$)/', '', $img) ?: $img;
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
            Log::warning('CrawlerCaraguatatuba: erro ao baixar imagem', [
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
            $thumbnail = preg_replace('/(\.\w+)$/', '-530x350$1', $imageUrl);

            if (! is_string($thumbnail) || $thumbnail === $imageUrl) {
                return null;
            }

            try {
                return $client->request('GET', $thumbnail)->getContent();
            } catch (Throwable) {
                return null;
            }
        }
    }

    private function parsePublishDate(Crawler $item): Carbon
    {
        $dateNode = $item->filter('.card-footer small');

        if ($dateNode->count() > 0 && preg_match('/(\d{2}\/\d{2}\/\d{4})/', $dateNode->text(), $matches) === 1) {
            try {
                return Carbon::createFromFormat('d/m/Y', $matches[1])->startOfDay();
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
