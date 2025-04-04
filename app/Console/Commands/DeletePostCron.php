<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\PostController;
use Illuminate\Console\Command;

class DeletePostCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deletepost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Post after 12 months';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $controller = new PostController();
        $controller->deleteCron();
    }
}
