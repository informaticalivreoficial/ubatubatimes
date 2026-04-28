<?php

namespace App\Jobs;

use App\Services\CrawlerIlhabelaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportIlhabelaNoticias implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(CrawlerIlhabelaService $service): void
    {
        $service->run();
    }
}
