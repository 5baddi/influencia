<?php

namespace App\Console;

use App\Console\Commands\AppUpdaterCommand;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ScrapInstagramInfluencers;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ScrapInstagramInfluencers::class,
        AppUpdaterCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Start jobs queue
        $schedule->command('queue:work --queue=default,trackers')
            ->daily()
            ->withoutOverlapping();

        // Instagram scraper
        $schedule->command('scrap:instagram')
            ->everyMinute(env('INSTAGRAM_SCHEDULE'))
            ->withoutOverlapping();

        // Updater
        $schedule->command('updater:app')
            ->dailyAt('00:00')
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
