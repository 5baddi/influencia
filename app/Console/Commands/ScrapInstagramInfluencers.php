<?php

namespace App\Console\Commands;

use App\Tracker;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\InstagramScraper;
use App\Jobs\ScrapInstagramPostJob;
use App\Repositories\TrackerRepository;
use App\Repositories\InfluencerRepository;
use App\Repositories\InfluencerPostRepository;

class ScrapInstagramInfluencers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:instagram {--force=false} {post?}';

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
     * Influencer post repository
     * 
     * @var \App\Repositories\InfluencerPostRepository
     */
    private $postRepo;
    
    /**
     * Tracker repository
     * 
     * @var \App\Repositories\TrackerRepository
     */
    private $trackerRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        InstagramScraper $instagramScraper, 
        InfluencerRepository $repository, 
        InfluencerPostRepository $postRepo,
        TrackerRepository $trackerRepo)
    {
        parent::__construct();

        // Init
        $this->instagramScraper = $instagramScraper;
        $this->repository = $repository;
        $this->postRepo = $postRepo;
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

        // ScrapInstagramPostJob::dispatchNow(Tracker::create([
        //     'name'  =>  'Tracker ' . rand(),
        //     'type'  =>  'post',
        //     'user_id'   =>  1,
        //     'campaign_id'   =>  1,
        //     'platform'  =>  'instagram',
        //     'url'           =>  'https://www.instagram.com/p/CGkUPvGoFW5/;https://www.instagram.com/p/CF15DhMI8Zg/;'
        // ]));
        // die();

        // Scrap influencers details & posts
        $this->scrapInfluencers();

        // Scrap trackers details & analytics
        $this->scrapTrackers();

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
        $influencers = $this->repository->all();
        $this->info("Number of account to sync: " . $influencers->count());

        // Scrap each influencer details
        foreach($influencers as $influencer){
            // Ignore last updated influencer
            if($this->option('force') === 'false' && $influencer->posts()->count() > 0  && isset($influencer->updated_at) && $influencer->updated_at->diffInDays(Carbon::now()) === 0)
                continue;

            // Scrap account details
            $this->info("Start scraping account @" . $influencer->username);
            $accountDetails = $this->instagramScraper->byUsername($influencer->username);

            // Update influencer
            $this->repository->update($influencer, $accountDetails);
            $this->info("Successfully updated influencer @" . $influencer->username);
            $influencer->fresh();

            // Update influencer posts
            $this->info("Number of posts: " . $influencer->posts);
            $this->info("Please wait until scraping all medias ...");
            $this->instagramScraper->getMedias($influencer);
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
        $trackers = $this->trackerRepo->getInstagram();
        $this->info("Number of trackers to sync: " . $trackers->count());

        // Scrap each tracker details
        foreach($trackers as $tracker){
            // Ignore last updated trackers
            if($this->option('force') === 'false' && isset($tracker->updated_at) && $tracker->updated_at->diffInDays(Carbon::now()) === 0)
                continue;

            // TODO: scrap stories details
            if($tracker->type === 'story')
                continue;

            if($tracker->type === 'post'){
                // Get post
                $post = $this->postRepo->getPostByTracker($tracker);

                // TODO: Update username and platform
                // Scrap post details
                if(!is_null($post)){
                    $trackerData = [
                        'nbr_replies'   =>  $post->comments,
                        'nbr_squences'  =>  $post->sequences
                    ];

                    // Update tracker analytics
                    $this->info("Updating tracker @" . $tracker->name ?? $tracker->uuid);
                    $this->trackerRepo->update($tracker, $trackerData);
                }
            }
        }
    }
}
