<?php

namespace App\Console\Commands;

use App\Jobs\ImportCaraguatatubaNoticias;
use Illuminate\Console\Command;

class NoticiaCaraguaCreate extends Command
{
    protected $signature = 'app:noticiacaragua';
    protected $description = 'Cria notícia puxando do site da prefeitura de Caraguatatuba';

    public function handle(): void
    {
        ImportCaraguatatubaNoticias::dispatch();

        $this->info('Crawler enviado para fila!');
    }
}
