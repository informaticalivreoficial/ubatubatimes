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

class CrawlerTamoiosService
{
    public function run(): void
    {
        $client = HttpClient::create([
            'timeout' => 15,
        ]);

        $baseUrl = 'https://www23.concessionariatamoios.com.br';
        $url = $baseUrl;

        try {
            // 📌 LISTAGEM
            $response = $client->request('GET', $url);
            $crawler = new Crawler($response->getContent());

            $item = $crawler->filter('.front-noticia .row')->first();

            if ($item->count() === 0) {
                logger()->warning('Tamoios: nenhuma notícia encontrada');
                return;
            }

            // 📝 TÍTULO + LINK
            $titleNode = $item->filter('h3 a');

            if ($titleNode->count() === 0) {
                return;
            }

            $title = trim($titleNode->text());
            $link  = $baseUrl . $titleNode->attr('href');

            // 🔒 DUPLICADO
            $slug = Str::slug($title);

            if (Post::where('slug', $slug)->exists()) {
                return;
            }

            // 🖼️ IMAGEM DA LISTAGEM
            $img = null;

            if ($item->filter('img')->count()) {
                $img = $item->filter('img')->attr('src');

                // corrige timthumb
                if (str_contains($img, 'timthumb.php')) {
                    parse_str(parse_url($img, PHP_URL_QUERY), $params);
                    $img = $params['src'] ?? $img;
                }

                if (!str_starts_with($img, 'http')) {
                    $img = $baseUrl . '/' . ltrim($img, '/');
                }
            }

            // 📄 CONTEÚDO DA NOTÍCIA
            $responseNoticia = $client->request('GET', $link);
            $crawlerNoticia = new Crawler($responseNoticia->getContent());

            $content = '';

            if ($crawlerNoticia->filter('.news-content')->count()) {
                $content = $crawlerNoticia->filter('.news-content')->html();
            }

            // 💾 SALVA POST
            $post = Post::create([
                'type' => 'noticia',
                'autor' => 1,
                'title' => $title,
                'slug' => $slug,
                'content' => $content . '<br><br><small>Fonte: Concessionária Tamoios</small>',
                'cat_pai' => 56,
                'category' => 77,
                'status' => 1,
            ]);

            // 📥 IMAGEM
            if ($img) {
                try {
                    $manager = new ImageManager(new Driver());

                    $imageResponse = $client->request('GET', $img);
                    $imageContent = $imageResponse->getContent();

                    $image = $manager->read($imageContent);
                    $image->scaleDown(width: 1920);

                    $webp = $image->toWebp(85);

                    $name = Str::slug($post->title) . '.webp';
                    $path = 'posts/noticia/' . $post->id . '/' . $name;

                    Storage::put($path, (string) $webp);

                    PostGb::create([
                        'post' => $post->id,
                        'cover' => true,
                        'path' => $path,
                    ]);

                } catch (\Exception $e) {
                    logger()->warning('Tamoios: erro imagem', [
                        'error' => $e->getMessage()
                    ]);
                }
            }

        } catch (\Exception $e) {
            logger()->error('Tamoios: erro crawler', [
                'error' => $e->getMessage()
            ]);
        }
    }
}