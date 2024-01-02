<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\PostController;
use Illuminate\Console\Command;

class NoticiaCaraguaCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:noticiacaragua';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria notícia puxando do site da prefeitura de Caraguatatuba';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $controller = new PostController();
        $controller->crowlerNoticiasCaraguatatuba();
    }
}
