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

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:noticiaubatuba')->everyMinute()->withoutOverlapping();                
        $schedule->command('app:noticiacaragua')->everyMinute()->withoutOverlapping();                
        $schedule->command('app:noticiasaosebastiao')->everyMinute()->withoutOverlapping();                
        //$schedule->command('app:noticiailhabela')->everyMinute()->withoutOverlapping();      
        $schedule->command('app:fundartubatuba')->everyMinute()->withoutOverlapping();      
        $schedule->command('app:deletepost')->everyMinute()->withoutOverlapping();      
        $schedule->command('app:clear-trash-cron')->everyMinute()->withoutOverlapping();      
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
