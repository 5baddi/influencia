<?php

namespace App\Console;

use App\Console\Commands\InstagramCommand;
use App\Console\Commands\AppUpdaterCommand;
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
        AppUpdaterCommand::class,
        InstagramCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // App updater
        $schedule->command('updater:app')
            ->dailyAt('00:00')
            ->withoutOverlapping();
            
        // Start jobs queue
        $schedule->command('queue:work --queue=high,default,trackers')
            ->everyMinute()
            ->withoutOverlapping();

        // Instagram scraper
        $schedule->command('scrap:instagram')
            ->everyTenMinutes()
            ->withoutOverlapping();
            
        // Influencers updater
        $schedule->command('scrap:instagram --update')
            ->hourly()
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
