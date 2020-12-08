<?php

namespace App\Console;

use App\Console\Commands\InstagramCommand;
use App\Console\Commands\AppUpdaterCommand;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\RetryScrapPostCommand;
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
        InstagramCommand::class,
        RetryScrapPostCommand::class,
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
            ->dailyAt('00:00');
            
        // Start jobs queue
        $schedule->command('queue:work --queue=high,default,trackers')
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping(60);

        // Retry failed scrap post jobs
        $schedule->command('scrap:retry')
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping(10);

        // Instagram scraper
        $schedule->command('scrap:instagram')
            ->everyMinute()
            ->withoutOverlapping(60);
            
        // Influencers updater
        $schedule->command('scrap:instagram --update')
            ->everyMinute()
            ->withoutOverlapping(60);
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
