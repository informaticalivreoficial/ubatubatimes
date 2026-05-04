<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //Commands\SitemapUpdate::class,
    ];
    
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:noticiaubatuba')->everyMinute();            
        $schedule->command('app:noticiacaragua')->everyMinute();                
        $schedule->command('app:noticiasaosebastiao')->everyMinute();                
        $schedule->command('app:noticiailhabela')->everyMinute();      
        $schedule->command('app:fundartubatuba')->everyMinute();   
        $schedule->command('app:novatamoioscreate')->everyMinute();      
        $schedule->command('posts:clean-old')->everyMinute();      
        $schedule->command('posts:purge-deleted')->everyMinute();      
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
