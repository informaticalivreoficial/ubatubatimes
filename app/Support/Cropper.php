<?php

namespace App\Support;


class Cropper
{
    public static function thumb(string $uri, int $width, $height = null)
    {
        $cropper = new \CoffeeCode\Cropper\Cropper('../public/storage/cache');
        $pathThumb = $cropper->make(config('filesystems.disks.public.root') . '/' . $uri, $width, $height);

        $file = 'cache/' . collect(explode('/', $pathThumb))->last();
        return $file;
    }

    public static function flush(?string $path)
    {
        $cropper = new \CoffeeCode\Cropper\Cropper('../public/storage/cache');

        if(!empty($path)) {
            $cropper->flush($path);
        } else {
            $cropper->flush();
        }

    }
}