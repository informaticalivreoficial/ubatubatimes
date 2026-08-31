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

class CrawlerIlhabelaService
{
    private const BASE_URL = 'https://www.ilhabela.sp.gov.br';

    private const LISTING_URL = self::BASE_URL . '/portal/noticias';

    private const AUTHOR_ID = 1;

    private const CAT_PAI = 56;

    private const CATEGORY = 76;

    public function run(): void
    {
        try {
            $html = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; UbatubaTimes/1.0)',
                ])
                ->get(self::LISTING_URL)
                ->body();

            $crawler = new Crawler($html);
            $node = $crawler->filter('.ntc_cont_noticias a')->first();

            if (! $node->count()) {
                Log::warning('CrawlerIlhabela: nenhuma notícia encontrada');

                return;
            }

            $this->processItem($node);
        } catch (Throwable $exception) {
            Log::error('CrawlerIlhabela: erro geral', [
                'erro' => $exception->getMessage(),
            ]);
        }
    }

    private function processItem(Crawler $node): void
    {
        $titleNode = $node->filter('.ntc_titulo_noticia');

        if ($titleNode->count() === 0) {
            return;
        }

        $title = trim($titleNode->text());
        $slug = Str::slug($title);

        if ($title === '') {
            return;
        }

        if (Post::where('slug', $slug)->orWhere('title', $title)->exists()) {
            Log::info('CrawlerIlhabela: já existe', ['title' => $title]);

            return;
        }

        $link = $this->absoluteUrl($node->attr('href'));

        if ($link === null) {
            return;
        }

        $contentHtml = Http::timeout(30)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; UbatubaTimes/1.0)',
            ])
            ->get($link)
            ->body();

        $contentCrawler = new Crawler($contentHtml);

        $content = $this->getContent($contentCrawler);

        $post = Post::create([
            'type' => 'noticia',
            'autor' => self::AUTHOR_ID,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'cat_pai' => self::CAT_PAI,
            'category' => self::CATEGORY,
            'status' => 1,
            'publish_at' => now(),
        ]);

        $this->handleImage($contentCrawler, $post);
    }

    private function getContent(Crawler $crawler): string
    {
        try {
            $node = $crawler->filter('.ntc_descricao_noticia .ntc_cont_descricao_noticia');

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
            . '<br><br><small>Fonte: <a target="_blank" href="' . self::BASE_URL . '/">Prefeitura de Ilhabela</a></small>';
    }

    private function handleImage(Crawler $crawler, Post $post): void
    {
        try {
            $imgNode = $crawler
                ->filter('.ntc_area_slide_imagens_noticia img')
                ->first();

            if (! $imgNode->count()) {
                return;
            }

            $img = $imgNode->attr('src') ?: $imgNode->attr('data-src');

            if (! $img) {
                return;
            }

            $img = $this->absoluteUrl($img);

            if ($img === null) {
                return;
            }

            $manager = new ImageManager(new Driver());

            $imageContent = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; UbatubaTimes/1.0)',
                ])
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
            Log::warning('CrawlerIlhabela: erro ao salvar imagem', [
                'erro' => $exception->getMessage(),
            ]);
        }
    }

    private function absoluteUrl(?string $url): ?string
    {
        if ($url === null || trim($url) === '') {
            return null;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        return self::BASE_URL . '/' . ltrim($url, '/');
    }
}
