<?php

namespace App\Jobs;

use App\Services\CrawlerSaoSebastiaoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportSaoSebastiaoNoticias implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(CrawlerSaoSebastiaoService $service): void
    {
        $service->run();
    }
}