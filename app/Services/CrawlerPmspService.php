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

class CrawlerPmspService
{
    private const BASE_URL = 'https://portaldenoticias.policiamilitar.sp.gov.br';

    private const NEWS_PATH = '/noticias/';

    private const CAT_PAI = 56;

    private const AUTHOR_ID = 1;

    private const POST_TYPE = 'noticia';

    private const SOURCE_LABEL = 'Portal de Notícias da PMESP';

    public function run(): void
    {
        Log::info('[CrawlerPMESP] ▶ Iniciando crawl.');

        try {
            $html = $this->fetchHtml(self::BASE_URL . self::NEWS_PATH);

            if (! $html) {
                Log::error('[CrawlerPMESP] ✗ HTML da listagem veio vazio ou falhou.');

                return;
            }

            $crawler = new Crawler($html);
            $node = $crawler->filter('article.wpr-grid-item')->first();

            if (! $node->count()) {
                Log::warning('[CrawlerPMESP] ✗ Nenhum article.wpr-grid-item encontrado.');

                return;
            }

            $this->processItem($node);
        } catch (Throwable $exception) {
            Log::error('[CrawlerPMESP] ✗ Erro geral', [
                'erro' => $exception->getMessage(),
            ]);
        }
    }

    private function processItem(Crawler $node): void
    {
        $titleNode = $node->filter('.wpr-grid-item-title a');

        if (! $titleNode->count()) {
            Log::warning('[CrawlerPMESP] ✗ Seletor .wpr-grid-item-title a não encontrou nada.');

            return;
        }

        $title = trim($titleNode->text());
        $link = $titleNode->attr('href');

        $category = $this->resolveCategory($title);

        if (! $category) {
            return;
        }

        Log::info("[CrawlerPMESP] Categoria resolvida: {$category} para \"{$title}\"");

        if (Post::where('title', $title)->exists()) {
            Log::info('[CrawlerPMESP] ⏭ Notícia já existe, pulando.');

            return;
        }

        $contentHtml = $this->fetchHtml($link);

        if (! $contentHtml) {
            Log::error("[CrawlerPMESP] ✗ Falha ao buscar conteúdo: {$link}");

            return;
        }

        $contentCrawler = new Crawler($contentHtml);

        try {
            $post = Post::create([
                'type' => self::POST_TYPE,
                'autor' => self::AUTHOR_ID,
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => $this->extractContent($contentCrawler),
                'cat_pai' => self::CAT_PAI,
                'category' => $category,
                'status' => 1,
                'publish_at' => $this->parsePublishDate($node),
            ]);

            Log::info("[CrawlerPMESP] ✓ Post criado com ID: {$post->id}");
        } catch (Throwable $exception) {
            Log::error('[CrawlerPMESP] ✗ Falha ao criar Post: ' . $exception->getMessage());

            return;
        }

        $this->handleImage($node, $contentCrawler, $post);

        Log::info('[CrawlerPMESP] ✓ Crawl finalizado com sucesso.');
    }

    private function fetchHtml(string $url): ?string
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'pt-BR,pt;q=0.9',
                ])
                ->get($url);

            if (! $response->successful()) {
                Log::warning("[CrawlerPMESP] ✗ Status {$response->status()} para {$url}");

                return null;
            }

            return $response->body();
        } catch (Throwable $exception) {
            Log::error("[CrawlerPMESP] ✗ Exceção ao buscar {$url}: {$exception->getMessage()}");

            return null;
        }
    }

    private function extractContent(Crawler $crawler): string
    {
        try {
            $node = $crawler->filter('.elementor-widget-theme-post-content .elementor-widget-container')->first();

            if (! $node->count() || trim($node->text()) === '') {
                Log::warning('[CrawlerPMESP] ✗ Seletor de conteúdo não encontrou nada.');
                $body = '';
            } else {
                $body = $node->html();

                $body = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $body) ?? $body;
                $body = preg_replace('#<style\b[^>]*>.*?</style>#is', '', $body) ?? $body;

                $bodyCrawler = new Crawler('<div>' . $body . '</div>');
                $body = $bodyCrawler->filter('div')->first()->children()->reduce(function (Crawler $node) {
                    return $node->nodeName() !== 'figure';
                })->each(function (Crawler $node) {
                    return $node->outerHtml();
                });

                $body = implode('', $body);

                Log::info('[CrawlerPMESP] ✓ Conteúdo extraído (' . mb_strlen(strip_tags($body)) . ' chars).');
            }
        } catch (Throwable $exception) {
            Log::warning('[CrawlerPMESP] ✗ Exceção ao extrair conteúdo: ' . $exception->getMessage());
            $body = '';
        }

        return $body . sprintf(
            '<br><br><small>Fonte: <a target="_blank" href="%s">%s</a></small>',
            self::BASE_URL,
            self::SOURCE_LABEL
        );
    }

    private function handleImage(Crawler $listNode, Crawler $contentCrawler, Post $post): void
    {
        $imgUrl = $this->extractImageFromCard($listNode)
            ?? $this->extractImageFromMeta($contentCrawler);

        if (! $imgUrl) {
            Log::warning("[CrawlerPMESP] ✗ Nenhuma imagem encontrada para post {$post->id}.");

            return;
        }

        Log::info("[CrawlerPMESP] Imagem: {$imgUrl}");

        try {
            $manager = new ImageManager(new Driver());

            $imageContent = Http::timeout(15)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; UbatubaTimes/1.0)',
                ])
                ->get($imgUrl)
                ->body();

            if (empty($imageContent)) {
                Log::warning("[CrawlerPMESP] ✗ Download vazio: {$imgUrl}");

                return;
            }

            $image = $manager->read($imageContent);
            $image->scaleDown(width: 1920);

            $path = sprintf('posts/%s/%d/%s', self::POST_TYPE, $post->id, Str::slug($post->title) . '.webp');

            Storage::disk('public')->put($path, (string) $image->toWebp(85));

            PostGb::create([
                'post' => $post->id,
                'cover' => true,
                'path' => $path,
            ]);

            Log::info("[CrawlerPMESP] ✓ Imagem salva em: {$path}");
        } catch (Throwable $exception) {
            Log::warning("[CrawlerPMESP] ✗ Erro ao baixar imagem", [
                'img' => $imgUrl,
                'erro' => $exception->getMessage(),
            ]);
        }
    }

    private function extractImageFromCard(Crawler $node): ?string
    {
        try {
            $img = $node->filter('.wpr-grid-image-wrap img')->first();

            if (! $img->count()) {
                return null;
            }

            $src = $img->attr('src') ?: $img->attr('data-src') ?: null;

            if ($src === null || trim($src) === '') {
                return null;
            }

            if (! str_starts_with($src, 'http')) {
                $src = self::BASE_URL . '/' . ltrim($src, '/');
            }

            return $src;
        } catch (Throwable) {
            Log::warning('[CrawlerPMESP] Falha ao extrair imagem do card');

            return null;
        }
    }

    private function extractImageFromMeta(Crawler $crawler): ?string
    {
        try {
            $meta = $crawler->filter('meta[property="og:image"]')->first();

            return $meta->count() ? $meta->attr('content') : null;
        } catch (Throwable) {
            Log::warning('[CrawlerPMESP] Falha ao extrair og:image');

            return null;
        }
    }

    private function parsePublishDate(Crawler $node): Carbon
    {
        try {
            $dateNode = $node->filter('.wpr-grid-item-meta time, .wpr-grid-item-meta .date');

            if ($dateNode->count() > 0) {
                $dateText = trim($dateNode->text());

                if (preg_match('/(\d{2})\/(\d{2})\/(\d{4})/', $dateText, $matches) === 1) {
                    return Carbon::createFromFormat('d/m/Y', "{$matches[1]}/{$matches[2]}/{$matches[3]}")->startOfDay();
                }
            }
        } catch (Throwable) {
            // usa a data atual
        }

        return now();
    }

    private function resolveCategory(string $title): int
    {
        $map = [
            'Ubatuba' => 73,
            'Caraguatatuba' => 74,
            'São Sebastião' => 75,
            'Ilhabela' => 76,
            'Litoral Norte' => 89,
        ];

        foreach ($map as $keyword => $categoryId) {
            if (mb_stripos($title, $keyword) !== false) {
                return $categoryId;
            }
        }

        Log::info("[CrawlerPMESP] ⏭ Título sem cidade do Litoral Norte, pulando: \"{$title}\"");

        return 0;
    }
}
