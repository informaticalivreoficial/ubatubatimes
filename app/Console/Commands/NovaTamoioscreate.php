<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\PostController;
use Illuminate\Console\Command;

class NovaTamoioscreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:novatamoioscreate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria notícia puxando do site da nova tamoios';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $controller = new PostController();
        $controller->crowlerNoticiasNovaTamoios(); 
    }
}
