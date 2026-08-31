<?php

namespace App\Console\Commands;

use App\Support\Cropper;
use Illuminate\Console\Command;

class ClearThumbCache extends Command
{
    protected $signature = 'cache:clear-thumbs';

    protected $description = 'Limpa o cache local de thumbnails (storage/app/public/cache)';

    public function handle(): int
    {
        $cachePath = public_path('storage/cache');
        $total = is_dir($cachePath) ? count(glob($cachePath . '/*.webp') ?: []) : 0;

        Cropper::flush();

        $this->info("Cache de thumbnails limpo! {$total} arquivo(s) removido(s).");

        return Command::SUCCESS;
    }
}
