<?php

namespace App\Console;

use App\Console\Commands\InstagramCommand;
use App\Console\Commands\AppUpdaterCommand;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\RetryScrapPostCommand;
use App\Console\Commands\UpdateAnalyticsCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\InstagramStoriesCommand;

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
        UpdateAnalyticsCommand::class,
        InstagramStoriesCommand::class,
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
            
        // Analytics updater
        $schedule->command('analytics:update')
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping(10);

        // Retry failed scrap post jobs
        $schedule->command('scrap:retry')
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping(10);

        // Instagram scraper
        $schedule->command('scrap:instagram')
            ->everyTenMinutes()
            ->runInBackground()
            ->withoutOverlapping(60);
            
        // Influencers updater
        $schedule->command('scrap:instagram --update')
            ->hourly()
            ->runInBackground()
            ->withoutOverlapping(60);
            
        // Scrap stories of Instagram influencers
        $schedule->command('stories:instagram')
            ->hourly()
            ->runInBackground()
            ->withoutOverlapping(60);

        // Remove unused instagram stories
        $schedule->command('stories:instagram --remove')
            ->monthly();
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
