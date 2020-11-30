<?php

namespace App\Console;

use App\Console\Commands\AppUpdaterCommand;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\TrackersUpdaterCommand;
use App\Console\Commands\InfluencersUpdaterCommand;
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
        AppUpdaterCommand::class,
        TrackersUpdaterCommand::class,
        InfluencersUpdaterCommand::class
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
        // $schedule->command('queue:work --queue=high,default,trackers --timeout=600')
        //     ->hourly()
        //     ->withoutOverlapping();

        // Instagram scraper
        $schedule->command('scrap:instagram')
            ->everyMinute()
            ->withoutOverlapping();
            
        // Trackers updater
        $schedule->command('updater:trackers')
            ->everyMinute()
            ->withoutOverlapping();
            
        // Influencers updater
        $schedule->command('updater:influencers')
            ->daily()
            ->withoutOverlapping();

        // App updater
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
