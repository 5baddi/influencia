<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Influencer;
use Illuminate\Console\Command;
use App\Services\InstagramScraper;

class ScrapInstagramInfluencers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:instagram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap instagram influencers';

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

        try{
            // Scrap user
            $username = 'nims97_rs3';
           dd($this->instagramScraper->byUsername($username));

        }catch(\Exception $ex){
            dd($ex);
        }
        die();
        $this->info("=== Start scraping instagram ===");
        $startTaskAt = microtime(true);

        // Scrap influencers details & posts
        $this->scrapInfluencers();

        $this->info("=== Done ===");
        $endTaskAt = microtime(true) - $startTaskAt;
        $this->info("Total Execution Time: " . Carbon::createFromTimestamp($endTaskAt)->toTimeString());
    }

    /**
     * Scrap influencers details and medias
     *
     * @return void
     */
    private function scrapInfluencers() : void
    {
        // Get influencers
        $influencers = Influencer::with(['trackers', 'posts'])->get();
        $this->info("Number of account to sync: " . $influencers->count());

        // Scrap each influencer details
        foreach($influencers as $influencer){
            try{
                // Scrap account details
                $this->info("Start scraping account @" . $influencer->username);
                $accountDetails = $this->instagramScraper->byUsername($influencer->username);

                // Update influencer
                $influencer->update($accountDetails);
                $influencer->refresh();
                $this->info("Successfully updated influencer @" . $influencer->username);

                // Ignore last updated influencers
                if($influencer->posts()->count() === $influencer->medias)
                    continue;

                // Update influencer posts
                $this->info("Number of posts: " . $influencer->medias);
                $this->info("Already scraped posts: " . $influencer->posts()->count());
                $this->info("Please wait until scraping all medias ...");
                $this->instagramScraper->getMedias($influencer);
            }catch(\Exception $ex){
                $this->error($ex->getMessage());

                // Break process if necessary
                if($ex->getCode() === 111)
                    break;
            }
        }
    }
}
