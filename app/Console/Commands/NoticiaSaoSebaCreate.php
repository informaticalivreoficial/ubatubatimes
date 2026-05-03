<?php

namespace App\Console\Commands;

use App\Jobs\ImportSaoSebastiaoNoticias;
use Illuminate\Console\Command;

class NoticiaSaoSebaCreate extends Command
{
    protected $signature = 'app:noticiasaosebastiao';
    protected $description = 'Cria notícia puxando do site da prefeitura de São Sebastião';
    
    public function handle(): void
    {
        ImportSaoSebastiaoNoticias::dispatch();
        $this->info('Crawler enviado para fila!');
    }
}
