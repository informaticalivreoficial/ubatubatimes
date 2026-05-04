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
        $schedule->command('app:noticiaubatuba')->dailyAt('12:30');            
        $schedule->command('app:noticiacaragua')->dailyAt('12:30');                
        $schedule->command('app:noticiasaosebastiao')->dailyAt('12:30');                
        $schedule->command('app:noticiailhabela')->dailyAt('12:30');      
        $schedule->command('app:fundartubatuba')->dailyAt('12:30');   
        $schedule->command('app:novatamoioscreate')->dailyAt('12:30');      
        $schedule->command('posts:clean-old')->dailyAt('12:30');      
        $schedule->command('posts:purge-deleted')->dailyAt('12:30');      
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
