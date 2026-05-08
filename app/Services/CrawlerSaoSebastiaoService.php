<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostGb;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerSaoSebastiaoService
{
    protected string $baseUrl = 'https://www.saosebastiao.sp.gov.br';

    private function httpClient(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::timeout(15)
            ->withHeaders([
                'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language' => 'pt-BR,pt;q=0.9,en;q=0.8',
                'Referer'         => $this->baseUrl,
            ]);
    }

    public function run(): void
    {
        try {
            $response = $this->httpClient()->get($this->baseUrl . '/noticia-lista.asp');

            Log::info('CrawlerSaoSebastiao: resposta lista', [
                'status' => $response->status(),
                'body'   => substr($response->body(), 0, 1000),
            ]);

            if (!$response->successful()) {
                Log::warning('CrawlerSaoSebastiao: resposta não OK', [
                    'status' => $response->status(),
                ]);
                return;
            }

            $html    = $response->body();
            $crawler = new Crawler($html);
            $article = $crawler->filter('article.notice')->first();

            if (!$article->count()) {
                Log::warning('CrawlerSaoSebastiao: nenhuma notícia encontrada no HTML');
                return;
            }

            $this->processArticle($article);

        } catch (\Exception $e) {
            Log::error('CrawlerSaoSebastiao: erro geral', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    private function processArticle(Crawler $article): void
    {
        $linkNode = $article->filter('.notice-title a');
        if (!$linkNode->count()) {
            Log::warning('CrawlerSaoSebastiao: link da notícia não encontrado');
            return;
        }

        $title = trim($linkNode->text());
        $slug  = Str::slug($title);
        $href  = $linkNode->attr('href');

        if (Post::where('title', $title)->exists()) {
            Log::info('CrawlerSaoSebastiao: notícia já existe, pulando', ['title' => $title]);
            return;
        }

        $link = $this->baseUrl . '/' . ltrim($href, '/');

        Log::info('CrawlerSaoSebastiao: buscando conteúdo', ['link' => $link]);

        $contentResponse = $this->httpClient()->get($link);

        if (!$contentResponse->successful()) {
            Log::warning('CrawlerSaoSebastiao: erro ao buscar conteúdo da notícia', [
                'status' => $contentResponse->status(),
                'link'   => $link,
            ]);
            return;
        }

        $contentCrawler = new Crawler($contentResponse->body());

        $post = Post::create([
            'type'       => 'noticia',
            'autor'      => 1,
            'title'      => $title,
            'slug'       => $slug,
            'content'    => $this->getContent($contentCrawler),
            'cat_pai'    => 56,
            'category'   => 75,
            'status'     => 1,
            'publish_at' => now(),
        ]);

        Log::info('CrawlerSaoSebastiao: post criado', ['title' => $title, 'id' => $post->id]);

        $this->handleImage($contentCrawler, $post);
    }

    private function getContent(Crawler $crawler): string
    {
        try {
            $content = $crawler->filter('.post-content-inner')->html();
        } catch (\Exception $e) {
            Log::warning('CrawlerSaoSebastiao: conteúdo não encontrado', ['error' => $e->getMessage()]);
            $content = '';
        }

        return $content . '<br><br><small>Fonte: <a target="_blank" href="https://www.saosebastiao.sp.gov.br/">Prefeitura de São Sebastião</a></small>';
    }

    private function handleImage(Crawler $crawler, Post $post): void
    {
        try {
            $slideNode = $crawler->filter('.slide-list .slide')->first();

            if (!$slideNode->count()) {
                Log::info('CrawlerSaoSebastiao: nenhum slide encontrado', ['post_id' => $post->id]);
                return;
            }

            $style = $slideNode->attr('style');

            preg_match("/background-image:\s*url\('([^']+)'\)/", $style, $matches);

            if (empty($matches[1])) {
                Log::warning('CrawlerSaoSebastiao: imagem não encontrada no style', ['style' => $style]);
                return;
            }

            $imgPath = $matches[1];
            $imgUrl  = str_starts_with($imgPath, 'http')
                ? $imgPath
                : $this->baseUrl . '/' . ltrim($imgPath, '/');

            Log::info('CrawlerSaoSebastiao: baixando imagem', ['url' => $imgUrl]);

            $imageContent = $this->httpClient()->get($imgUrl)->body();

            if (empty($imageContent)) {
                Log::warning('CrawlerSaoSebastiao: imagem vazia', ['url' => $imgUrl]);
                return;
            }

            $image = @imagecreatefromstring($imageContent);

            if ($image === false) {
                Log::warning('CrawlerSaoSebastiao: falha ao criar imagem GD', ['url' => $imgUrl]);
                return;
            }

            ob_start();
            imagewebp($image, null, 85);
            $webp = ob_get_clean();
            imagedestroy($image);

            $path = 'posts/noticia/' . $post->id . '/' . uniqid() . '.webp';
            Storage::disk('public')->put($path, $webp);

            PostGb::create([
                'post'  => $post->id,
                'cover' => true,
                'path'  => $path,
            ]);

            Log::info('CrawlerSaoSebastiao: imagem salva', ['path' => $path]);

        } catch (\Exception $e) {
            Log::error('CrawlerSaoSebastiao: erro ao salvar imagem', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}