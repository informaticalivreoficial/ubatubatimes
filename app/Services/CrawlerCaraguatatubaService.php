<?php

namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostGb;
use Illuminate\Support\Facades\Log;

class CrawlerCaraguatatubaService
{
    public function run(): void
    {
        $client = HttpClient::create();

        try {
            $url = 'https://www.caraguatatuba.sp.gov.br/pmc/';
            $response = $client->request('GET', $url);

            $crawler = new Crawler($response->getContent());

            $crawler->filter('#featuredNews .card')->each(function ($item) use ($client) {

                try {
                    // 🔹 título
                    $title = trim($item->filter('h5 a')->text());
                    $slug  = Str::slug($title);

                    // 🔹 evita duplicado
                    if (Post::where('title', $title)->exists()) {
                        return;
                    }

                    // 🔹 link
                    $link = $item->filter('h5 a')->attr('href');

                    // 🔹 conteúdo da notícia
                    $responseContent = $client->request('GET', $link);
                    $contentCrawler  = new Crawler($responseContent->getContent());

                    $content = $contentCrawler->filter('.card-text')->count()
                        ? $contentCrawler->filter('.card-text')->html()
                        : '';

                    $content .= '<br><br><small>Fonte: Prefeitura de Caraguatatuba</small>';

                    // 🔹 cria post
                    $post = Post::create([
                        'type'       => 'noticia',
                        'autor'      => 1,
                        'title'      => $title,
                        'slug'       => $slug,
                        'content'    => $content,
                        'cat_pai' => 3,
                        'category' => 12,
                        'status'     => true,
                        'publish_at' => now(),
                    ]);

                    // 🔹 imagem (da listagem)
                    if ($item->filter('img')->count()) {
                        $img = $item->filter('img')->attr('src');

                        if (!str_starts_with($img, 'http')) {
                            $img = 'https://www.caraguatatuba.sp.gov.br' . $img;
                        }

                        $imageContent = @file_get_contents($img);

                        if ($imageContent) {
                            $name = uniqid() . '.webp';
                            $path = 'posts/noticia/' . $post->id . '/' . $name;

                            $image = imagecreatefromstring($imageContent);

                            if ($image !== false) {
                                ob_start();
                                imagewebp($image, null, 85);
                                $webp = ob_get_clean();

                                Storage::put($path, $webp);

                                PostGb::create([
                                    'post'  => $post->id,
                                    'path'  => $path,
                                    'cover' => true,
                                ]);

                                imagedestroy($image);
                            }
                        }
                    }

                    // \Log::info('Caraguatatuba: post criado', [
                    //     'title' => $title
                    // ]);

                } catch (\Exception $e) {
                    Log::error('Erro item Caraguatatuba', [
                        'error' => $e->getMessage()
                    ]);
                }
            });

        } catch (\Exception $e) {
            Log::error('Erro geral crawler Caraguatatuba', [
                'error' => $e->getMessage()
            ]);
        }
    }
}