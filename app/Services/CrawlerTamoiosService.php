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

class CrawlerTamoiosService
{
    private const BASE_URL = 'https://www23.concessionariatamoios.com.br';

    private const AUTHOR_ID = 1;

    private const CAT_PAI = 56;

    private const CATEGORY = 77;

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
            $response = $client->request('GET', self::BASE_URL);
            $crawler = new Crawler($response->getContent());
            $item = $crawler->filter('.front-noticia .row')->first();

            if (! $item->count()) {
                Log::warning('CrawlerTamoios: nenhuma notícia encontrada');

                return;
            }

            $this->processItem($item, $client, $manager);
        } catch (Throwable $exception) {
            Log::error('CrawlerTamoios: erro crawler', [
                'erro' => $exception->getMessage(),
            ]);
        }
    }

    private function processItem(Crawler $item, HttpClientInterface $client, ImageManager $manager): void
    {
        $titleNode = $item->filter('h3 a');

        if ($titleNode->count() === 0) {
            return;
        }

        $title = trim($titleNode->text());
        $slug = Str::slug($title);
        $link = self::BASE_URL . $titleNode->attr('href');

        if ($title === '') {
            return;
        }

        if (Post::where('slug', $slug)->orWhere('title', $title)->exists()) {
            Log::info('CrawlerTamoios: já existe', ['title' => $title]);

            return;
        }

        $responseNoticia = $client->request('GET', $link);
        $crawlerNoticia = new Crawler($responseNoticia->getContent());

        $content = '';

        if ($crawlerNoticia->filter('.news-content')->count()) {
            $html = $crawlerNoticia->filter('.news-content')->html();
            $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html) ?? $html;
            $html = preg_replace('#<style\b[^>]*>.*?</style>#is', '', $html) ?? $html;
            $content = $html;
        }

        $post = Post::create([
            'type' => 'noticia',
            'autor' => self::AUTHOR_ID,
            'title' => $title,
            'slug' => $slug,
            'content' => $content . '<br><br><small>Fonte: Concessionária Tamoios</small>',
            'cat_pai' => self::CAT_PAI,
            'category' => self::CATEGORY,
            'status' => 1,
            'publish_at' => $this->parsePublishDate($item),
        ]);

        $imageUrl = $this->extractImage($item);

        if ($imageUrl !== null) {
            $this->storeCover($client, $manager, $post, $imageUrl);
        }
    }

    private function extractImage(Crawler $item): ?string
    {
        if (! $item->filter('img')->count()) {
            return null;
        }

        $img = $item->filter('img')->attr('src');

        if (str_contains($img, 'timthumb.php')) {
            parse_str(parse_url($img, PHP_URL_QUERY), $params);
            $img = $params['src'] ?? $img;
        }

        if (! str_starts_with($img, 'http')) {
            $img = self::BASE_URL . '/' . ltrim($img, '/');
        }

        return $img;
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
            Log::warning('CrawlerTamoios: erro imagem', [
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
        $dateNode = $item->filter('.blog-item-details .date, .date');

        if ($dateNode->count() > 0) {
            try {
                return Carbon::createFromFormat('d/m/Y', trim($dateNode->text()))->startOfDay();
            } catch (Throwable) {
                // usa a data atual
            }
        }

        return now();
    }
}
