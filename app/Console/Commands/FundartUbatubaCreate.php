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
    protected $signature = 'fundartubatuba:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria uma notícia da fundart de ubatuba';

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
        $controller->crowlerFundartUbatuba();
    }
}
