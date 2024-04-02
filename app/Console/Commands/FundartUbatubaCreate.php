<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\PostController;
use Illuminate\Console\Command;

class FundartUbatubaCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fundartubatuba';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria uma notícia da fundart de ubatuba';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $controller = new PostController();
        $controller->crowlerFundartUbatuba();
    }
}
