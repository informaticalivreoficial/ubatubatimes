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
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('noticiaubatuba:create')->everyMinute()->withoutOverlapping();                
        $schedule->command('noticiacaragua:create')->everyMinute()->withoutOverlapping();                
        $schedule->command('noticiasaosebastiao:create')->everyMinute()->withoutOverlapping();                
        $schedule->command('noticiailhabela:create')->everyMinute()->withoutOverlapping();      
        $schedule->command('fundartubatuba:create')->everyMinute()->withoutOverlapping();      
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
