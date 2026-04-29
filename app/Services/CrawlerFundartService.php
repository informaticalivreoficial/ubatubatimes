<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostGb;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CrawlerFundartService
{
    public function run(): void
    {
        $client = HttpClient::create();
        $manager = new ImageManager(new Driver());

        $baseUrl = 'https://fundart.com.br';
        $url = $baseUrl . '/noticias';

        try {
            $response = $client->request('GET', $url);
            $crawler = new Crawler($response->getContent());

            // 🔥 pega SOMENTE a primeira notícia
            $item = $crawler->filter('.archive-posts article.list-post')->first();

            if (!$item->count()) {
                logger('Fundart: Nenhuma notícia encontrada');
                return;
            }

            // 📰 título + link
            $title = trim($item->filter('h2.list-post-title')->text());
            $slug  = Str::slug($title);
            $link  = $item->filter('a')->attr('href');

            if (!str_starts_with($link, 'http')) {
                $link = $baseUrl . $link;
            }

            // 🚫 evita duplicado
            if (Post::where('slug', $slug)->exists()) {
                logger('Fundart: Já existe', ['title' => $title]);
                return;
            }

            // 🔎 acessa página da notícia
            $response = $client->request('GET', $link);
            $contentCrawler = new Crawler($response->getContent());

            // 📄 conteúdo completo
            $content = $contentCrawler
                ->filter('.single-content')
                ->html();

            $content .= '<br><br><small>Fonte: <a href="https://fundart.com.br" target="_blank">FundArt</a></small>';

            // 🖼️ imagem (alta qualidade via srcset)
            $imgNode = $contentCrawler->filter('.single-content img')->first();
            $img = null;

            if ($imgNode->count()) {

                $srcset = $imgNode->attr('srcset');

                if ($srcset) {
                    $sources = explode(',', $srcset);
                    $last = trim(end($sources));
                    $img = explode(' ', $last)[0];
                } else {
                    $img = $imgNode->attr('src');
                }

                if ($img && !str_starts_with($img, 'http')) {
                    $img = $baseUrl . $img;
                }
            }

            // 💾 cria post
            $post = Post::create([
                'type' => 'noticia',
                'autor' => 1,
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'cat_pai' => 56,
                'category' => 73,
                'status' => true,
            ]);

            // 📥 baixa imagem e converte para webp
            if ($img) {
                try {
                    $imageResponse = $client->request('GET', $img);
                    $imageContent = $imageResponse->getContent();

                    $image = $manager->read($imageContent);
                    $image->scaleDown(width: 1920);

                    $webp = $image->toWebp(85);

                    $name = Str::slug($title) . '.webp';
                    $path = 'posts/noticia/' . $post->id . '/' . $name;

                    Storage::put($path, (string) $webp);

                    PostGb::create([
                        'post' => $post->id,
                        'cover' => true,
                        'path' => $path,
                    ]);

                } catch (\Exception $e) {
                    logger('Fundart: erro imagem', [
                        'erro' => $e->getMessage(),
                        'url' => $img
                    ]);
                }
            } else {
                logger('Fundart: sem imagem', ['url' => $link]);
            }

        } catch (\Exception $e) {
            logger('Fundart: erro geral', [
                'erro' => $e->getMessage()
            ]);
        }
    }
}