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
	    $schedule->command('sitemap:generate')->everyMinute()->withoutOverlapping();
        $schedule->command('app:noticiaubatuba')->everyMinute()->withoutOverlapping();            
        $schedule->command('app:noticiacaragua')->everyMinute()->withoutOverlapping();                
        $schedule->command('app:noticiasaosebastiao')->everyMinute()->withoutOverlapping();                
        $schedule->command('app:noticiailhabela')->everyMinute()->withoutOverlapping();      
        $schedule->command('app:fundartubatuba')->everyMinute()->withoutOverlapping();   
        $schedule->command('app:novatamoioscreate')->everyMinute()->withoutOverlapping();         
        $schedule->command('app:noticia-pm-s-p-create')->everyMinute()->withoutOverlapping(); 
        $schedule->command('posts:clean-old')->everyMinute()->withoutOverlapping();      
        $schedule->command('posts:purge-deleted')->everyMinute()->withoutOverlapping();
        $schedule->command('app:clear-logs')->everyMinute()->withoutOverlapping();        
        $schedule->command('boletim:postar')->everyMinute()->withoutOverlapping();    
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
