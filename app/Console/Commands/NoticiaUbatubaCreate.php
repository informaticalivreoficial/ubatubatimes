<?php

namespace App\Console\Commands;

use App\Jobs\ImportUbatubaNoticias;
use Illuminate\Console\Command;

class NoticiaUbatubaCreate extends Command
{    
    protected $signature = 'app:noticiaubatuba';    
    protected $description = 'Cria notícia puxando do site da prefeitura de Ubatuba';
    
    public function handle(): void
    {
        ImportUbatubaNoticias::dispatch();

        $this->info('Crawler enviado para fila!');
    }
}
