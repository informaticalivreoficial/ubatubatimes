<?php

namespace App\Console\Commands;

use App\Jobs\ImportIlhabelaNoticias;
use Illuminate\Console\Command;

class NoticiaIlhabelaCreate extends Command
{
    protected $signature = 'app:noticiailhabela';
    protected $description = 'Cria notícia puxando do site da prefeitura de Ilhabela';
    
    public function handle(): void
    {
        ImportIlhabelaNoticias::dispatch();

        $this->info('Crawler enviado para fila!');
    }
}
