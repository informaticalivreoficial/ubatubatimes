<?php

namespace App\Console\Commands;

use App\Jobs\ImportPmSPNoticias;
use Illuminate\Console\Command;

class NoticiaPmSPCreate extends Command
{
    protected $signature = 'app:noticia-pm-s-p-create';
    protected $description = 'Command description';

    public function handle()
    {
        ImportPmSPNoticias::dispatch();
        $this->info('Crawler enviado para fila!');
    }
}
