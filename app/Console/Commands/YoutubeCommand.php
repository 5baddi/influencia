<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\YoutubeScraper;

class YoutubeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:youtube {--update}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap youtube influencers';

    /**
     * Youtube scraper
     *
     * @var \App\Services\YoutubeScraper
     */
    private $youtubeScraper;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(YoutubeScraper $youtubeScraper)
    {
        parent::__construct();

        // Init
        $this->youtubeScraper = $youtubeScraper;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Init start at time
        $startTaskAt = microtime(true);
        $this->info("=== Start " . ($this->option('update') ? "updating" : "scraping") . " youtube influencers ===");

        dd($this->youtubeScraper->extractChannelID("https://www.youtube.com/channel/UCCB1Byx5yTbLpQaV-rlfmtA"));
        // Start scraping or updating influencers
        // if(!$this->option('update'))
        //     $this->scrapInfluencers();
        // else
        //     $this->updateInfluencers();

        $this->info("=== Done ===");
        $endTaskAt = microtime(true) - $startTaskAt;
        $this->info("Total Execution Time: " . Carbon::createFromTimestamp($endTaskAt)->toTimeString());
    }
}
