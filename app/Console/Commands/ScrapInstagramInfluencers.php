<?php

namespace App\Console\Commands;

use App\Tracker;
use Carbon\Carbon;
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
    const RANGE_MINUTES = 15;

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
        $this->info("=== Start scraping instagram ===");
        $startTaskAt = microtime(true);

        // Scrap influencers details & posts
        $this->scrapInfluencers();

        // Scrap trackers details & analytics
        $this->scrapTrackers();

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
        $influencers = $this->repository->all();
        $this->info("Number of account to sync: " . $influencers->count());

        // Scrap each influencer details
        foreach($influencers as $influencer){
            try{
                // Update influencer queued state
                $influencer->update(['queued' => 'progress']);

                // Scrap account details
                $this->info("Start scraping account @" . $influencer->username);
                $accountDetails = $this->instagramScraper->byUsername($influencer->username);

                // Update influencer
                $influencer = $this->repository->update($influencer, $accountDetails);
                $this->info("Successfully updated influencer @" . $influencer->username);

                // Ignore last updated influencers
                if($influencer->posts()->count() == $influencer->posts && isset($influencer->updated_at) && $influencer->updated_at->diffInDays(Carbon::now()) === 0){
                    $influencer->update(['queued' => 'finished']);

                    continue;
                }

                // Update influencer posts
                $this->info("Number of posts: " . $influencer->posts);
                $this->info("Already scraped posts: " . $influencer->posts()->count());
                $this->info("Please wait until scraping all medias ...");
                $lastPost = $influencer->posts()->where('influencer_id', $influencer->id)->whereNotNull('next_cursor')->latest()->first();
                $force = (!is_null($lastPost) && $lastPost->updated_at->diffInDays(Carbon::now()) > 1);
                $this->instagramScraper->getMedias($influencer, $force);
                $influencer->refresh();

                // Update influencer queued state
               if($influencer->posts()->count() === $influencer->posts)
                    $influencer->update(['queued' => 'finished']);

                // Verify the max requests calls
                if(self::checkPassedMaxCalls()){
                    $this->error("We will continue scraping after one hour because bypass the max requests per hour!");
                    return;
                }
            }catch(\Exception $ex){
                $this->error($ex->getMessage());
                $this->error("Failed to scrap influencer @{$influencer->username}");
                Log::error($ex->getMessage());

                $influencer->update(['queued' => 'failed']);
            }
        }
    }

    /**
     * Scrap trackers details and analytics
     *
     * @return void
     */
    private function scrapTrackers() : void
    {
        // Get trackers
        $trackers = Tracker::with(['posts'])->get();
        $this->info("Number of trackers to sync: " . $trackers->count());

        // Scrap each tracker details
        foreach($trackers as $tracker){
            // TODO: scrap stories details
            if($tracker->platform === "instagram" && $tracker->type === "story")
                continue;

            if($tracker->platform === "instagram" && $tracker->type === "post"){
                // Update trackers & influencers queued state
                $scrapedInfluencers = 0;
                foreach($tracker->posts->load('influencer') as $post){
                    if($post->influencer->posts()->count() == $post->influencer->posts){
                        if($post->influencer->queued !== 'finished')
                            $post->influencer->update(['queued' => 'finished']);

                        ++$scrapedInfluencers;
                    }
                }

                // Set tracker queued as finished
                if($tracker->influencers->count() === $scrapedInfluencers)
                    $tracker->update(['queued' => 'finished']);
            }
        }
    }
}
