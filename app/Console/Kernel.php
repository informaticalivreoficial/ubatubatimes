<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //Commands\SitemapUpdate::class,
    ];
    
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:noticiaubatuba')->everyMinute();            
        $schedule->command('app:noticiacaragua')->everyMinute();                
        //$schedule->command('app:noticiasaosebastiao')->everyMinute()->withoutOverlapping();                
        $schedule->command('app:noticiailhabela')->everyMinute();      
        $schedule->command('app:fundartubatuba')->everyMinute();   
        $schedule->command('app:novatamoioscreate')->everyMinute();      
        //$schedule->command('app:deletepost')->everyMinute()->withoutOverlapping();      
        //$schedule->command('app:clear-trash-cron')->everyMinute()->withoutOverlapping();      
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
