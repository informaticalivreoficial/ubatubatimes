<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostGb;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerPmspService
{
    protected string $baseUrl = 'https://portaldenoticias.policiamilitar.sp.gov.br';

    private const NEWS_PATH    = '/noticias/';
    private const CAT_PAI      = 56;
    //private const CATEGORY     = 89;
    private const AUTOR        = 1;
    private const POST_TYPE    = 'noticia';
    private const SOURCE_LABEL = 'Portal de Notícias da PMESP';

    public function run(): void
    {
        Log::info('[CrawlerPMESP] ▶ Iniciando crawl.');

        $html = $this->fetchHtml($this->baseUrl . self::NEWS_PATH);

        if (!$html) {
            Log::error('[CrawlerPMESP] ✗ HTML da listagem veio vazio ou falhou.');
            return;
        }

        $crawler = new Crawler($html);

        // Plugin WP Royal Grid — cada notícia é um article.wpr-grid-item
        $node = $crawler->filter('article.wpr-grid-item')->first();

        if (!$node->count()) {
            Log::warning('[CrawlerPMESP] ✗ Nenhum article.wpr-grid-item encontrado.');
            return;
        }

        // Título e link ficam em .wpr-grid-item-title a
        $titleNode = $node->filter('.wpr-grid-item-title a');

        if (!$titleNode->count()) {
            Log::warning('[CrawlerPMESP] ✗ Seletor .wpr-grid-item-title a não encontrou nada.');
            return;
        }

        $title = trim($titleNode->text());
        $link  = $titleNode->attr('href');

        $category = $this->resolveCategory($title);

        if (!$category) {
            return;
        }

        Log::info("[CrawlerPMESP] Categoria resolvida: {$category} para \"{$title}\"");

        if (Post::where('title', $title)->exists()) {
            Log::info("[CrawlerPMESP] ⏭ Notícia já existe, pulando.");
            return;
        }

        $contentHtml = $this->fetchHtml($link);

        if (!$contentHtml) {
            Log::error("[CrawlerPMESP] ✗ Falha ao buscar conteúdo: {$link}");
            return;
        }

        $contentCrawler = new Crawler($contentHtml);

        try {
            $post = Post::create([
                'type'     => self::POST_TYPE,
                'autor'    => self::AUTOR,
                'title'    => $title,
                'slug'     => Str::slug($title),
                'content' => $this->extractContent($contentCrawler),
                'cat_pai'  => self::CAT_PAI,
                'category' => $category,
                'status'   => 1,
            ]);

            Log::info("[CrawlerPMESP] ✓ Post criado com ID: {$post->id}");
        } catch (\Exception $e) {
            Log::error('[CrawlerPMESP] ✗ Falha ao criar Post: ' . $e->getMessage());
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
                    'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                    'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'pt-BR,pt;q=0.9',
                ])
                ->get($url);

            if (!$response->successful()) {
                Log::warning("[CrawlerPMESP] ✗ Status {$response->status()} para {$url}");
                return null;
            }

            return $response->body();
        } catch (\Exception $e) {
            Log::error("[CrawlerPMESP] ✗ Exceção ao buscar {$url}: {$e->getMessage()}");
            return null;
        }
    }

    private function extractContent(Crawler $crawler): string
    {
        try {
            $node = $crawler->filter('.elementor-widget-theme-post-content .elementor-widget-container')->first();

            if (!$node->count() || trim($node->text()) === '') {
                Log::warning('[CrawlerPMESP] ✗ Seletor de conteúdo não encontrou nada.');
                $body = '';
            } else {
                $body = $node->html();

                // Remove a figura/imagem do topo — ela é salva separadamente no PostGb
                $bodyCrawler = new Crawler('<div>' . $body . '</div>');
                $body = $bodyCrawler->filter('div')->first()->children()->reduce(function (Crawler $node) {
                    return $node->nodeName() !== 'figure';
                })->each(function (Crawler $node) {
                    return $node->outerHtml();
                });

                $body = implode('', $body);

                Log::info('[CrawlerPMESP] ✓ Conteúdo extraído (' . mb_strlen(strip_tags($body)) . ' chars).');
            }
        } catch (\Exception $e) {
            Log::warning('[CrawlerPMESP] ✗ Exceção ao extrair conteúdo: ' . $e->getMessage());
            $body = '';
        }

        return $body . sprintf(
            '<br><br><small>Fonte: <a target="_blank" href="%s">%s</a></small>',
            $this->baseUrl,
            self::SOURCE_LABEL
        );
    }

    private function handleImage(Crawler $listNode, Crawler $contentCrawler, Post $post): void
    {
        // Prioridade 1: imagem do card na listagem (já disponível, evita um request extra)
        // Fica em .wpr-grid-image-wrap img — o src já é a URL absoluta
        $imgUrl = $this->extractImageFromCard($listNode)
            ?? $this->extractImageFromMeta($contentCrawler);

        if (!$imgUrl) {
            Log::warning("[CrawlerPMESP] ✗ Nenhuma imagem encontrada para post {$post->id}.");
            return;
        }

        Log::info("[CrawlerPMESP] Imagem: {$imgUrl}");

        $imageContent = $this->downloadImage($imgUrl);

        if (!$imageContent) {
            return;
        }

        $filename = basename(parse_url($imgUrl, PHP_URL_PATH));
        $path     = sprintf('posts/%s/%d/%s', self::POST_TYPE, $post->id, $filename);

        Storage::put($path, $imageContent);

        PostGb::create([
            'post'  => $post->id,
            'cover' => true,
            'path'  => $path,
        ]);

        Log::info("[CrawlerPMESP] ✓ Imagem salva em: {$path}");
    }

    private function extractImageFromCard(Crawler $node): ?string
    {
        try {
            $img = $node->filter('.wpr-grid-image-wrap img')->first();

            if (!$img->count()) {
                return null;
            }

            // Tenta src direto (já presente no HTML estático, sem lazy load)
            return $img->attr('src') ?: $img->attr('data-src') ?: null;
        } catch (\Exception $e) {
            Log::warning('[CrawlerPMESP] Falha ao extrair imagem do card: ' . $e->getMessage());
            return null;
        }
    }

    private function extractImageFromMeta(Crawler $crawler): ?string
    {
        try {
            $meta = $crawler->filter('meta[property="og:image"]')->first();
            return $meta->count() ? $meta->attr('content') : null;
        } catch (\Exception $e) {
            Log::warning('[CrawlerPMESP] Falha ao extrair og:image: ' . $e->getMessage());
            return null;
        }
    }

    private function downloadImage(string $url): ?string
    {
        $content = @file_get_contents($url);

        if ($content === false) {
            Log::warning("[CrawlerPMESP] ✗ Download falhou: {$url}");
            return null;
        }

        return $content;
    }

    private function resolveCategory(string $title): int
    {
        $map = [
            'Ubatuba'       => 73,
            'Caraguatatuba' => 74,
            'São Sebastião' => 75,
            'Ilhabela'      => 76,
            'Litoral Norte' => 89,
        ];

        foreach ($map as $keyword => $categoryId) {
            if (mb_stripos($title, $keyword) !== false) {
                return $categoryId;
            }
        }

        // Nenhuma palavra-chave encontrada — não cadastra
        Log::info("[CrawlerPMESP] ⏭ Título sem cidade do Litoral Norte, pulando: \"{$title}\"");
        return 0;
    }
}