<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostGb;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerIlhabelaService
{
    protected string $baseUrl = 'https://www.ilhabela.sp.gov.br';

    public function run(): void
    {
        $html = Http::get($this->baseUrl . '/portal/noticias')->body();

        $crawler = new Crawler($html);

        // pega só o primeiro item
        $node = $crawler->filter('.ntc_cont_noticias a')->first();

        if (!$node->count()) {
            return;
        }

        $title = trim($node->filter('.ntc_titulo_noticia')->text());
        $slug  = Str::slug($title);

        // evita duplicado
        if (Post::where('title', $title)->exists()) {
            return;
        }

        $link = $this->baseUrl . $node->attr('href');

        // entra na notícia
        $contentHtml = Http::get($link)->body();
        $contentCrawler = new Crawler($contentHtml);

        // conteúdo completo
        $content = $this->getContent($contentCrawler);

        // cria post
        $post = Post::create([
            'type'       => 'noticia',
            'autor'      => 1,
            'title'      => $title,
            'slug'       => $slug,
            'content'    => $content,
            'cat_pai'    => 3,
            'category'   => 12,
            'status'     => 1,
        ]);

        // imagem
        $this->handleImage($contentCrawler, $post);
    }

    private function getContent(Crawler $crawler): string
    {
        try {
            $content = $crawler
                ->filter('.ntc_descricao_noticia .ntc_cont_descricao_noticia')
                ->html();
        } catch (\Exception $e) {
            $content = '';
        }

        return $content . '<br><br><small>Fonte: <a target="_blank" href="https://www.ilhabela.sp.gov.br/">Prefeitura de Ilhabela</a></small>';
    }

    private function handleImage(Crawler $crawler, Post $post): void
    {
        try {
            $imgNode = $crawler
                ->filter('.ntc_area_slide_imagens_noticia img')
                ->first();

            if (!$imgNode->count()) {
                return;
            }

            $img = $imgNode->attr('src');

            if (!$img) {
                return;
            }

            // corrige URL relativa
            if (!str_starts_with($img, 'http')) {
                $img = $this->baseUrl . $img;
            }

            $imageContent = @file_get_contents($img);

            if (!$imageContent) {
                return;
            }

            $name = basename($img);
            $path = 'posts/noticia/' . $post->id . '/' . $name;

            Storage::put($path, $imageContent);

            PostGb::create([
                'post' => $post->id,
                'cover' => true,
                'path' => $path,
            ]);

        } catch (\Exception $e) {
            // pode logar se quiser
            // logger()->error($e->getMessage());
        }
    }
}