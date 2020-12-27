<?php

namespace App\Console\Commands;

use Format;
use Carbon\Carbon;
use App\Influencer;
use App\InfluencerPost;
use App\InfluencerPostMedia;
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
        // Get influencers
        $influencers = Influencer::with(['posts'])
                            ->where('platform', 'instagram')
                            ->orderBy('created_at', 'asc')
                            ->get();
        $this->info("Number of account to sync: " . $influencers->count());

        // Scrap each influencer details
        foreach($influencers as $influencer){
            try{
                // Ignore last updated influencers
                if($influencer->posts()->count() === $influencer->medias)
                    continue;

                // Update influencer posts
                $this->info("Start scraping account @" . $influencer->username);
                $this->info("Number of posts: " . $influencer->medias);
                $this->info("Already scraped posts: " . $influencer->posts()->count());
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
                    break;
            }
        }
    }

    /**
     * Update influencers details and medias
     *
     * @return void
     */
    private function updateInfluencers() : void
    {
        try{
            // Load all influencers
            $influencers = Influencer::with(['posts'])
                                ->where('platform', 'instagram')
                                ->where('updated_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())
                                ->get();
            $this->info("Influencers need update {$influencers->count()}");

            foreach($influencers as $influencer){
                // Ignore still in scraping queue
                if($influencer->posts->count() !== $influencer->medias)
                    continue;

                // Scrap account details
                $this->info("Start scraping account @" . $influencer->username);
                $accountDetails = $this->instagramScraper->byUsername($influencer->username);

                // Store influencer picture locally
                $accountDetails['pic_url'] = Format::storePicture($accountDetails['pic_url']);

                // Update influencer
                $influencer->update($accountDetails);
                $this->info("Successfully updated influencer @" . $influencer->username);
                
                foreach($influencer->posts as $post){
                    // Get online media
                    $_media = $this->instagramScraper->byMedia($post->short_code);
                    $media = $this->instagramScraper->getMedia($_media);
                    $this->info("Post {$media['short_code']} successfully scraped!");

                    // TODO: remove deleted media

                    // Update comments if post linked to a tracker
                    $mediaTrackersCount = TrackerInfluencerMedia::where('influencer_post_id', $post->id)->count();
                    if($mediaTrackersCount > 0){
                        // Analyze media comments
                        $sentiments = $this->instagramScraper->analyzeMedia($media);
                        $media = array_merge($media, $sentiments);

                        // Store media thumbnail locally
                        $media['thumbnail_url'] = Format::storePicture($media['thumbnail_url'], "influencers/instagram/thumbnails/");
                    }

                    // Update local media
                    $post->update($media);

                    $this->info("Post {$post->short_code} successfully updated.");
                }
            }
        }catch(\Exception $exception){
            // Trace
            Log::error($exception->getMessage(), [
                'context'   =>  "Instagram Updater with Code: {$exception->getCode()} Line: {$exception->getLine()}"
            ]);
            $this->error($exception->getMessage());
        }
    }
}
