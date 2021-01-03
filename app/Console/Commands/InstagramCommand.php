<?php

namespace App\Console\Commands;

use Format;
use Carbon\Carbon;
use App\Influencer;
use App\InfluencerPost;
use App\TrackerInfluencerMedia;
use Illuminate\Console\Command;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;

class InstagramCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:instagram {--update}';

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
        // Init start at time
        $startTaskAt = microtime(true);
        $this->info("=== Start " . ($this->option('update') ? "updating" : "scraping") . " instagram influencers ===");

        // Start scraping or updating influencers
        if(!$this->option('update'))
            $this->scrapInfluencers();
        else
            $this->updateInfluencers();

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
        // Handle by influencers
        Influencer::withCount(['posts'])
                    ->where('platform', 'instagram')
                    ->orderBy('created_at', 'asc')
                    ->chunk(50, function($influencers){
                        $this->info("Account number to synchronize: {$influencers->count()}");

                        // Scrap each influencer details
                        $influencers->each(function($influencer){
                            // Ignore last updated influencers
                            if($influencer->posts_count === $influencer->medias)
                                exit();

                            try{
                                // Influencer details
                                $this->info("Start scraping account @{$influencer->username}");
                                $this->info("Number of posts: {$influencer->medias}");
                                $this->info("Already scraped posts: {$influencer->posts_count}");
                                $this->info("Please wait until scraping all medias ...");

                                 // Get next cursor
                                $lastPost = InfluencerPost::where('influencer_id', $influencer->id)
                                                ->whereNotNull('next_cursor')
                                                ->orWhere('next_cursor', '!=', '')
                                                ->orderBy('id', 'desc')
                                                ->latest()
                                                ->first();

                                // Scrap new medias
                                $this->instagramScraper->getMedias($influencer, $lastPost->next_cursor ?? null);
                            }catch(\Exception $exception){
                                // Trace
                                Log::error($exception->getMessage(), [
                                    'context'   =>  "Instagram Updater with Code: {$exception->getCode()} Line: {$exception->getLine()}"
                                ]);
                                $this->error($exception->getMessage());
                
                                // Break process if necessary
                                if($exception->getCode() === 111)
                                    exit();
                            }
                        });
                    });
    }

    /**
     * Update influencers details and medias
     *
     * @return void
     */
    private function updateInfluencers() : void
    {
        // Handle by influencers
        Influencer::withCount(['posts'])
                    ->where('platform', 'instagram')
                    ->where('updated_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())
                    ->chunk(50, function($influencers){
                        $this->info("Influencers to update: {$influencers->count()}");

                        // Ignore still in scraping queue
                        if($influencer->posts_count < $influencer->medias)
                            exit();

                        try{
                            // Scrap account details
                            $this->info("Start scraping account @{$influencer->username}");
                            $accountDetails = $this->instagramScraper->byUsername($influencer->username);

                            // Update influencer
                            $influencer->update($accountDetails);
                            $this->info("Successfully updated influencer @{$influencer->username}");

                            // Load posts
                            $influencer->load('posts');
                            // Handle by posts
                            $influencer->posts->chunk(50, function($posts){
                                $posts->each(function($post){
                                    // Get online media
                                    $_media = $this->instagramScraper->byMedia($post->short_code);
                                    $this->info("Media {$media['short_code']} successfully scraped!");
                                    
                                    // Format media
                                    $media = $this->instagramScraper->getMedia($_media);

                                    // TODO: remove deleted media

                                    // Update comments if post linked to a tracker
                                    $mediaTrackersCount = TrackerInfluencerMedia::where('influencer_post_id', $post->id)->count();
                                    if($mediaTrackersCount > 0){
                                        // Analyze media comments
                                        $sentiments = $this->instagramScraper->analyzeMedia($media);
                                        $media = array_merge($media, $sentiments);
                                    }

                                    // Update local media
                                    $post->update($media);

                                    $this->info("Media {$post->short_code} successfully updated.");
                                });
                            });
                        }catch(\Exception $exception){
                            // Trace
                            Log::error($exception->getMessage(), [
                                'context'   =>  "Instagram Updater with Code: {$exception->getCode()} Line: {$exception->getLine()}"
                            ]);
                            $this->error($exception->getMessage());

                            // Break process if necessary
                            if($exception->getCode() === 111)
                                exit();
                        }
                    });
    }
}
