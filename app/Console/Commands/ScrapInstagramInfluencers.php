<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Influencer;
use App\InfluencerPost;
use Illuminate\Console\Command;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;
use App\Repositories\TrackerRepository;
use App\Repositories\InfluencerRepository;

class ScrapInstagramInfluencers extends Command
{
    /**
     * Max scraping calls by hour for Instagram
     */
    const MAX_CALLS = 200;

    /**
     * Minutes between each max calls
     */
    const RANGE_MINUTES = 60;

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
     * Influencer account repository
     *
     * @var \App\Repositories\InfluencerRepository
     */
    private $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        InstagramScraper $instagramScraper,
        InfluencerRepository $repository,
        TrackerRepository $trackerRepo)
    {
        parent::__construct();

        // Init
        $this->instagramScraper = $instagramScraper;
        $this->repository = $repository;
        $this->trackerRepo = $trackerRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Init scraper
        $this->instagramScraper = $this->instagramScraper->authenticate();

        $this->info("=== Start scraping instagram ===");
        $startTaskAt = microtime(true);

        // Scrap influencers details & posts
        $this->scrapInfluencers();

        $this->info("=== Done ===");
        $endTaskAt = microtime(true) - $startTaskAt;
        $this->info("Total Execution Time: " . Carbon::createFromTimestamp($endTaskAt)->toTimeString());
    }

    /**
     * Verify the max requests calls
     *
     * @return bool
     */
    public static function checkPassedMaxCalls()
    {
        $lastHourUpdatedRows = InfluencerPost::where('updated_at', '>=', Carbon::now()->subMinutes(self::RANGE_MINUTES)->toDateTimeString())->count();
        if($lastHourUpdatedRows >= self::MAX_CALLS)
            return true;

        return false;
    }

    /**
     * Scrap influencers details and medias
     *
     * @return void
     */
    private function scrapInfluencers() : void
    {
        // Verify the max requests calls
        if(self::checkPassedMaxCalls()){
            $this->error("We will continue scraping after one hour because bypass the max requests per hour!");
            return;
        }

        // Get influencers
        $influencers = Influencer::with(['trackers', 'posts'])->get();
        $this->info("Number of account to sync: " . $influencers->count());

        // Scrap each influencer details
        foreach($influencers as $influencer){
            try{
                // Update influencer queued state
                $this->updateQueue($influencer);

                // Scrap account details
                $this->info("Start scraping account @" . $influencer->username);
                $accountDetails = $this->instagramScraper->byUsername($influencer->username);

                // Update influencer
                $influencer->update($accountDetails);
                $influencer->refresh();
                $this->info("Successfully updated influencer @" . $influencer->username);

                // Ignore last updated influencers
                if($influencer->posts()->count() === $influencer->medias){
                    $influencer->update(['queued' => 'finished']);

                    continue;
                }

                // Update influencer posts
                $this->info("Number of posts: " . $influencer->medias);
                $this->info("Already scraped posts: " . $influencer->posts()->count());
                $this->info("Please wait until scraping all medias ...");
                $this->instagramScraper->getMedias($influencer);
                $influencer->refresh();

                // Update influencer queued state
               if($influencer->posts()->count() === $influencer->medias)
                    $influencer->update(['queued' => 'finished']);

                // Verify the max requests calls
                if(self::checkPassedMaxCalls()){
                    $this->error("We will continue scraping after one hour because bypass the max requests per hour!");
                    return;
                }
            }catch(\Exception $ex){
                dd($ex);
                // Trace
                $this->error($ex->getMessage());
                $this->error("Failed to scrap influencer @{$influencer->username}");
                Log::error($ex->getMessage());

                // Set tracker as failed
                $this->updateQueue($influencer, 'failed');

                // Break process if necessary
                if($ex->getCode() === -1)
                    break;
            }
        }
    }


    /**
     * Update influencer and related trackers queued state
     * 
     * @param \App\Influencer $influencer
     * @param string $queue
     * @return void
     */
    private function updateQueue(Influencer $influencer, string $queue = 'progress') : void
    {
        // Update influencer queued state
        $influencer->update(['queued' => $queue]);

        // Update trackers queued state
        foreach($influencer->trackers as $tracker)
            $tracker->update(['queued' => $queue]);
    }
}
