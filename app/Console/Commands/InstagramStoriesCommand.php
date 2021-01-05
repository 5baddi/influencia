<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Influencer;
use App\InfluencerStory;
use Illuminate\Console\Command;
use App\Services\InstagramScraper;

class InstagramStoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stories:instagram {--remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap stories for each instagram influencer';

    /**
     * Instagram scraper
     *
     * @var \App\Services\InstagramScraper
     */
    private $instagramScraper;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InstagramScraper $instagramScraper)
    {
        parent::__construct();

        // Init
        $this->instagramScraper = $instagramScraper;
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
        $this->info("=== Start " . ($this->option('remove') ? "removing" : "scraping") . " stories for each instagram influencer ===");

        // Start scraping or removing stories
        if(!$this->option('remove'))
            $this->scrapStories();
        else
            $this->removeStories();

        $this->info("=== Done ===");
        $endTaskAt = microtime(true) - $startTaskAt;
        $this->info("Total Execution Time: " . Carbon::createFromTimestamp($endTaskAt)->toTimeString());
    }

    /**
     * Scrap last 24hrs stories for each influencer
     *
     * @return void
     */
    private function scrapStories()
    {
        // Handle by influencers
        Influencer::where('platform', 'instagram')
                    ->orderBy('created_at', 'asc')
                    ->chunk(50, function($influencers){
                        $this->info("Account number to synchronize: {$influencers->count()}");

                        // Scrap stories for each influencer
                        $influencers->each(function($influencer){
                            // Scrap stories
                            $stories = collect($this->instagramScraper->getStories($influencer));

                            // Save stories
                            if($stories->count() > 0){
                                $stories->each(function($story){
                                    InfluencerStory::create($story);
                                });
                            }
                        });
                    });
    }

    /**
     * Remove unused stories for the last 24hrs
     *
     * @return void
     */
    private function removeStories()
    {
        // Handle by each story
        InfluencerStory::doesntHave('analytics')
                    ->where('published_at', '<=', Carbon::now()->subDays(30)->toDateTimeString())
                    ->delete();
    }
}
