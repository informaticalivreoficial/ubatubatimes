<?php

namespace App\Jobs;

use App\Services\CrawlerCaraguatatubaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportCaraguatatubaNoticias implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(CrawlerCaraguatatubaService $service): void
    {
        $service->run();
    }
}
