<?php

namespace App\Console\Commands;

use App\Tracker;
use Carbon\Carbon;
use App\Influencer;
use Illuminate\Console\Command;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;
use App\Repositories\TrackerRepository;
use App\Repositories\InfluencerRepository;

class ScrapInstagramInfluencers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:instagram {--force=false}';

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

            try{
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

                // Update influencer queued state
                $influencer->update(['queued', 'finished']);
            }catch(\Exception $ex){
                dd($ex);
                $influencer->update(['queued' => 'failed']);
                $this->error("Failed to scrap influencer @{$influencer->username}");
                Log::error($ex->getMessage());
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
        $trackers = $this->trackerRepo->getInstagram();
        $this->info("Number of trackers to sync: " . $trackers->count());

        // Scrap each tracker details
        foreach($trackers as $tracker){
            // Ignore last updated trackers
            if($this->option('force') === 'false' && isset($tracker->updated_at) && $tracker->updated_at->diffInDays(Carbon::now()) === 0)
                continue;

            // Ignore failed tracker
            if($tracker->queued === 'failed')
                continue;

            try{
                // TODO: scrap stories details
                if($tracker->type === 'story')
                    continue;

                if($tracker->type === 'post'){
                    // Update trackers & influencers queued state
                    $tracker = $tracker->load('posts');
                    foreach($tracker->posts->load('influencer') as $post){
                        if($post->influencer->queued === 'failed'){
                            $tracker->update(['queued' => 'failed', 'status' => false]);
                            $tracker = $tracker->refresh();

                            break;
                        }

                        if($post->influencer->posts()->count() == $post->influencer->posts){
                            if($post->influencer->queued !== 'finished')
                                $post->influencer->update(['queued' => 'finished']);

                            $tracker->update(['queued' => 'finished', 'status' => true]);
                            $tracker = $tracker->refresh();

                            continue;
                        }

                        $post->influencer->update(['queued' => 'progress']);
                        $tracker->update(['queued' => 'progress', 'status' => true]);
                        $tracker = $tracker->refresh();

                        break;
                    }
                }
            }catch(\Exception $ex){
                $tracker->update(['queued' => 'failed']);
                $this->error("Failed to scrap tracker {$tracker->uuid}");
                Log::error($ex->getMessage());

                continue;
            }
        }
    }
}
