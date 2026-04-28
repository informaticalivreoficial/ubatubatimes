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

class CrawlerUbatubaService
{
    public function run(): void
    {
        $client = HttpClient::create([
            'timeout' => 15,
        ]);

        $baseUrl = 'https://www.ubatuba.sp.gov.br';
        $url = $baseUrl . '/noticias/';

        try {
            $response = $client->request('GET', $url);
            $crawler  = new Crawler($response->getContent());

            $crawler->filter('.blog-items li')->each(function ($item) use ($client, $baseUrl) {

                // 📝 Título + link
                $title = trim($item->filter('h4')->text());
                $link  = $item->filter('h4 a')->attr('href');

                // 🔒 Evita duplicado (melhor usar slug)
                $slug = Str::slug($title);

                if (Post::where('slug', $slug)->exists()) {
                    return;
                }

                // 🖼️ IMAGEM (pega direto da listagem - mais rápido)
                $imgNode = $item->filter('figure img');

                $img = $imgNode->count()
                    ? $imgNode->attr('src')
                    : null;

                // Corrige URL relativa
                if ($img && !str_starts_with($img, 'http')) {
                    $img = $baseUrl . $img;
                }

                // Remove thumb (-480x260)
                if ($img) {
                    $img = preg_replace('/-\d+x\d+(?=\.\w+$)/', '', $img);
                }

                // 📄 Agora sim entra na página (1 request só quando necessário)
                try {
                    $response = $client->request('GET', $link);
                    $contentCrawler = new Crawler($response->getContent());

                    $content = $contentCrawler
                        ->filter('.article-body-wrap .body-text')
                        ->html();

                } catch (\Exception $e) {
                    logger('Erro ao acessar conteúdo', [
                        'link' => $link,
                        'erro' => $e->getMessage()
                    ]);
                    return;
                }

                // 💾 Cria post
                $post = Post::create([
                    'type' => 'noticia',
                    'autor' => 1,
                    'title' => $title,
                    'slug' => $slug,
                    'content' => $content . '<br><br><small>Fonte: Prefeitura de Ubatuba</small>',
                    'cat_pai' => 3,
                    'category' => 12,
                    'status' => 1,
                ]);

                // 📥 Baixar imagem
                if ($img) {
                    try {
                        $manager = new ImageManager(new Driver());

                        $imageResponse = $client->request('GET', $img);
                        $imageContent  = $imageResponse->getContent();

                        // cria imagem
                        $image = $manager->read($imageContent);

                        // opcional: redimensiona (melhor pra performance)
                        $image->scaleDown(width: 1920);

                        // converte para webp
                        $webp = $image->toWebp(85);

                        // nome final
                        $name = Str::slug($post->title) . '.webp';

                        $path = 'posts/noticia/' . $post->id . '/' . $name;

                        // salva
                        Storage::put($path, (string) $webp);

                        PostGb::create([
                            'post' => $post->id,
                            'cover' => true,
                            'path' => $path,
                        ]);

                    } catch (\Exception $e) {
                        logger('Erro ao baixar imagem', [
                            'img' => $img,
                            'erro' => $e->getMessage()
                        ]);
                    }
                }
            });

        } catch (\Exception $e) {
            logger('Erro geral no crawler', [
                'erro' => $e->getMessage()
            ]);
        }
    }
}