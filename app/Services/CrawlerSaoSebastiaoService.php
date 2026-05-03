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

    public function run(): void
    {
        try {
            $html    = Http::timeout(10)->get($this->baseUrl . '/noticia-lista.asp')->body();
            $crawler = new Crawler($html);
            $article = $crawler->filter('article.notice')->first();

            if (!$article->count()) {
                Log::warning('CrawlerSaoSebastiao: nenhuma notícia encontrada');
                return;
            }

            $this->processArticle($article);

        } catch (\Exception $e) {
            Log::error('CrawlerSaoSebastiao: erro geral', ['error' => $e->getMessage()]);
        }
    }

    private function processArticle(Crawler $article): void
    {
        $linkNode = $article->filter('.notice-title a');
        if (!$linkNode->count()) return;

        $title = trim($linkNode->text());
        $slug  = Str::slug($title);
        $href  = $linkNode->attr('href');

        if (Post::where('title', $title)->exists()) {
            Log::info('CrawlerSaoSebastiao: notícia já existe, pulando', ['title' => $title]);
            return;
        }

        $link = $this->baseUrl . '/' . ltrim($href, '/');

        $contentHtml    = Http::timeout(10)->get($link)->body();
        $contentCrawler = new Crawler($contentHtml);

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

        $this->handleImage($contentCrawler, $post);

        //Log::info('CrawlerSaoSebastiao: post criado', ['title' => $title]);
    }

    private function getContent(Crawler $crawler): string
    {
        try {
            $content = $crawler->filter('.post-content-inner')->html();
        } catch (\Exception $e) {
            $content = '';
        }

        return $content . '<br><br><small>Fonte: <a target="_blank" href="https://www.saosebastiao.sp.gov.br/">Prefeitura de São Sebastião</a></small>';
    }

    private function handleImage(Crawler $crawler, Post $post): void
    {
        try {
            $slideNode = $crawler->filter('.slide-list .slide')->first();

            if (!$slideNode->count()) return;

            $style = $slideNode->attr('style');

            preg_match("/background-image:\s*url\('([^']+)'\)/", $style, $matches);

            if (empty($matches[1])) return;

            $imgPath = $matches[1];

            $img = str_starts_with($imgPath, 'http')
                ? $imgPath
                : $this->baseUrl . '/' . ltrim($imgPath, '/');

            $imageContent = @file_get_contents($img);
            if (!$imageContent) return;

            $image = imagecreatefromstring($imageContent);
            if ($image === false) return;

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

        } catch (\Exception $e) {
            Log::error('CrawlerSaoSebastiao: erro ao salvar imagem', [
                'error' => $e->getMessage()
            ]);
        }
    }
}