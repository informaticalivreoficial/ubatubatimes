<?php

namespace App\Console\Commands;

use App\Jobs\ImportFundartNoticias;
use Illuminate\Console\Command;

class FundartUbatubaCreate extends Command
{
    protected $signature = 'app:fundartubatuba';
    protected $description = 'Cria uma notícia da fundart de ubatuba';

    public function handle(): void
    {
        ImportFundartNoticias::dispatch();

        $this->info('Crawler enviado para fila!');
    }
}
