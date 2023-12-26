<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\PostController;
use Illuminate\Console\Command;

class ClearTrashCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-trash-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpa Lixeira de Posts tipo notícias';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new PostController();
        $controller->clearTrash();
    }
}
