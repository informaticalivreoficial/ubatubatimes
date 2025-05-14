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
        // $schedule->command('app:noticiaubatuba')->everyMinute()->withoutOverlapping();                
        // $schedule->command('app:noticiacaragua')->everyMinute()->withoutOverlapping();                
        // $schedule->command('app:noticiasaosebastiao')->everyMinute()->withoutOverlapping();                
        // $schedule->command('app:noticiailhabela')->everyMinute()->withoutOverlapping();      
        // $schedule->command('app:fundartubatuba')->everyMinute()->withoutOverlapping();      
        // $schedule->command('app:deletepost')->everyMinute()->withoutOverlapping();      
        // $schedule->command('app:clear-trash-cron')->everyMinute()->withoutOverlapping();     
        /* ───── Crawlers de notícias ───── */
        // 08h05, 12h05, 16h05, 20h05
        $schedule->command('app:noticiaubatuba')
                ->cron('5 8,12,16,20 * * *')
                ->withoutOverlapping();

        // 08h15, 12h15, 16h15, 20h15
        $schedule->command('app:noticiacaragua')
                ->cron('15 8,12,16,20 * * *')
                ->withoutOverlapping();

        // 08h25, 12h25, 16h25, 20h25
        $schedule->command('app:noticiasaosebastiao')
                ->cron('25 8,12,16,20 * * *')
                ->withoutOverlapping();

        // 08h35, 12h35, 16h35, 20h35
        $schedule->command('app:noticiailhabela')
                ->cron('35 8,12,16,20 * * *')
                ->withoutOverlapping();

        /* ───── Manutenção ───── */
        // Limpa posts apagados às 02h00
        $schedule->command('app:deletepost')
                ->dailyAt('02:00')
                ->withoutOverlapping();

        // Limpa lixo temporário às 03h00
        $schedule->command('app:clear-trash-cron')
                ->dailyAt('03:00')
                ->withoutOverlapping(); 
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
