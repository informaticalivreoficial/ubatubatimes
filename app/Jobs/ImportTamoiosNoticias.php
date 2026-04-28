<?php

namespace App\Jobs;

use App\Services\CrawlerTamoiosService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportTamoiosNoticias implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(CrawlerTamoiosService $crawlerService): void
    {
        $crawlerService->run();
    }
}
