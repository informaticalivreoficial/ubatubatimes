<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostGb;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;

class CrawlerSaoSebastiaoService
{
    private const BASE_URL = 'https://www.saosebastiao.sp.gov.br';

    private const LISTING_URL = self::BASE_URL . '/noticia-lista.asp';

    private const AUTHOR_ID = 1;

    private const CAT_PAI = 56;

    private const CATEGORY = 75;

    private const HEADERS = [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
        'Accept-Language' => 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
        'Accept-Encoding' => 'gzip, deflate, br',
        'Referer' => 'https://www.google.com.br/',
        'Connection' => 'keep-alive',
        'Cache-Control' => 'max-age=0',
        'Sec-Fetch-Dest' => 'document',
        'Sec-Fetch-Mode' => 'navigate',
        'Sec-Fetch-Site' => 'cross-site',
        'Sec-Fetch-User' => '?1',
        'Upgrade-Insecure-Requests' => '1',
    ];

    public function run(): void
    {
        try {
            $html = Http::timeout(15)
                ->withHeaders(self::HEADERS)
                ->get(self::LISTING_URL)
                ->body();

            $crawler = new Crawler($html);
            $articles = $crawler->filter('article.featured-post');

            if ($articles->count() === 0) {
                Log::warning('CrawlerSaoSebastiao: nenhuma notícia encontrada');

                return;
            }

            foreach ($articles as $article) {
                $this->processArticle(new Crawler($article));
            }
        } catch (Throwable $exception) {
            Log::error('CrawlerSaoSebastiao: erro geral', [
                'erro' => $exception->getMessage(),
            ]);
        }
    }

    private function processArticle(Crawler $article): void
    {
        $linkNode = $article->filter('.post-title a');

        if (! $linkNode->count()) {
            return;
        }

        $title = trim($linkNode->text());
        $slug = Str::slug($title);
        $href = $linkNode->attr('href');

        if ($title === '') {
            return;
        }

        if (Post::where('slug', $slug)->orWhere('title', $title)->exists()) {
            Log::info('CrawlerSaoSebastiao: notícia já existe, pulando', ['title' => $title]);

            return;
        }

        $link = str_starts_with($href, 'http')
            ? $href
            : self::BASE_URL . '/' . ltrim($href, '/');

        $contentHtml = Http::timeout(15)
            ->withHeaders(self::HEADERS)
            ->get($link)
            ->body();

        $contentCrawler = new Crawler($contentHtml);

        $post = Post::create([
            'type' => 'noticia',
            'autor' => self::AUTHOR_ID,
            'title' => $title,
            'slug' => $slug,
            'content' => $this->getContent($contentCrawler),
            'cat_pai' => self::CAT_PAI,
            'category' => self::CATEGORY,
            'status' => 1,
            'publish_at' => $this->parsePublishDate($article),
        ]);

        $this->handleImage($article, $post);
    }

    private function getContent(Crawler $crawler): string
    {
        try {
            $node = $crawler->filter('.post-content-inner');

            if ($node->count() === 0) {
                $content = '';
            } else {
                $html = $node->html();
                $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html) ?? $html;
                $html = preg_replace('#<style\b[^>]*>.*?</style>#is', '', $html) ?? $html;
                $content = $html;
            }
        } catch (Throwable) {
            $content = '';
        }

        return $content
            . '<br><br><small>Fonte: <a target="_blank" href="' . self::BASE_URL . '/">Prefeitura de São Sebastião</a></small>';
    }

    private function handleImage(Crawler $article, Post $post): void
    {
        try {
            $imgNode = $article->filter('.post-image img')->first();

            if (! $imgNode->count()) {
                return;
            }

            $imgPath = $imgNode->attr('src');

            if (empty($imgPath)) {
                return;
            }

            $img = str_starts_with($imgPath, 'http')
                ? $imgPath
                : self::BASE_URL . '/' . ltrim($imgPath, '/');

            $manager = new ImageManager(new Driver());

            $imageContent = Http::timeout(15)
                ->withHeaders(self::HEADERS)
                ->get($img)
                ->body();

            if (empty($imageContent)) {
                return;
            }

            $image = $manager->read($imageContent);
            $image->scaleDown(width: 1920);

            $path = 'posts/noticia/' . $post->id . '/' . Str::slug($post->title) . '.webp';

            Storage::disk()->put($path, (string) $image->toWebp(85));

            PostGb::create([
                'post' => $post->id,
                'cover' => true,
                'path' => $path,
            ]);
        } catch (Throwable $exception) {
            Log::error('CrawlerSaoSebastiao: erro ao salvar imagem', [
                'erro' => $exception->getMessage(),
            ]);
        }
    }

    private function parsePublishDate(Crawler $article): Carbon
    {
        try {
            $dateNode = $article->filter('.post-date');

            if ($dateNode->count() > 0) {
                $dateText = trim($dateNode->text());

                if (preg_match('/(\d{2})\s+de\s+(\w+)\s+de\s+(\d{4})/', $dateText, $matches) === 1) {
                    $meses = [
                        'janeiro' => 1, 'fevereiro' => 2, 'março' => 3, 'abril' => 4,
                        'maio' => 5, 'junho' => 6, 'julho' => 7, 'agosto' => 8,
                        'setembro' => 9, 'outubro' => 10, 'novembro' => 11, 'dezembro' => 12,
                    ];

                    $dia = (int) $matches[1];
                    $mes = $meses[strtolower($matches[2])] ?? 1;
                    $ano = (int) $matches[3];

                    return Carbon::create($ano, $mes, $dia)->startOfDay();
                }

                if (preg_match('/(\d{2})\/(\d{2})\/(\d{4})/', $dateText, $matches) === 1) {
                    return Carbon::createFromFormat('d/m/Y', "{$matches[1]}/{$matches[2]}/{$matches[3]}")->startOfDay();
                }
            }
        } catch (Throwable) {
            // usa a data atual
        }

        return now();
    }
}
