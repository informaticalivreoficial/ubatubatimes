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
    protected $signature = 'noticiailhabela:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria notícia puxando do site da prefeitura de Ilhabela';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new PostController();
        $controller->crowlerNoticiasIlhabela();
    }
}
