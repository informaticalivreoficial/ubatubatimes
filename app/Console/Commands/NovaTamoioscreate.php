<?php

namespace App\Console\Commands;

use App\Jobs\ImportTamoiosNoticias;
use Illuminate\Console\Command;

class NovaTamoioscreate extends Command
{
    protected $signature = 'app:novatamoioscreate';
    protected $description = 'Cria notícia puxando do site da nova tamoios';

    public function handle(): void
    {
        ImportTamoiosNoticias::dispatch();
        $this->info('Crawler enviado para fila!'); 
    }
}
