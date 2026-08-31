<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Throwable;

class Cropper
{
    public static function thumb(string $uri, int $width, ?int $height = null): string
    {
        $cachePath  = public_path('storage/cache');
        $filename   = md5($uri . $width . $height) . '.webp';
        $cachedFile = $cachePath . '/' . $filename;

        // ✅ retorna cache se já existir
        if (file_exists($cachedFile)) {
            return self::cacheUrl($filename);
        }

        if (!file_exists($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        // lê o arquivo do disco padrão (local ou R2/S3)
        if (!Storage::disk()->exists($uri)) {
            return '';
        }

        try {
            $manager = new ImageManager(new Driver());
            $image   = $manager->read(Storage::disk()->get($uri));

            // ✅ crop centralizado (igual ao Cropper) ou só redimensiona largura
            if ($height) {
                $image->cover($width, $height);
            } else {
                $image->scale(width: $width);
            }

            $image->toWebp(80)->save($cachedFile);
        } catch (Throwable) {
            return '';
        }

        return self::cacheUrl($filename);
    }

    /**
     * URL pública do cache local de thumbnails (sempre local, nunca no R2).
     */
    private static function cacheUrl(string $filename): string
    {
        return rtrim(config('app.url'), '/') . '/storage/cache/' . $filename;
    }

    public static function flush(?string $path = null): void
    {
        $cachePath = public_path('storage/cache');

        if (!empty($path)) {
            // ✅ limpa apenas as miniaturas da imagem específica
            $hash = md5($path);
            foreach (glob($cachePath . '/' . $hash . '*.webp') as $file) {
                if (is_file($file)) unlink($file);
            }
        } else {
            // ✅ limpa todo o cache
            foreach (glob($cachePath . '/*.webp') as $file) {
                if (is_file($file)) unlink($file);
            }
        }
    }
}