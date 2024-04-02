<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\PostController;
use Illuminate\Console\Command;

class NoticiaIlhabelaCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:noticiailhabela';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria notícia puxando do site da prefeitura de Ilhabela';
    
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $controller = new PostController();
        $controller->crowlerNoticiasIlhabela();
    }
}
