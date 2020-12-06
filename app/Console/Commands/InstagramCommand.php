<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Influencer;
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
        // Init 
        $ignoreInstagram = false;

        try{
            // Load all influencers
            $influencers = Influencer::with(['posts'])->where('updated_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())->get();
            $this->info("Influencers need update {$influencers->count()}");

            foreach($influencers as $influencer){
                // Ignore still in scraping queue
                if($influencer->posts->count() !== $influencer->medias)
                    continue;

                // Update instagram media
                if($influencer->platform === 'instagram' && !$ignoreInstagram){
                    // Break process if last one executed less than 10 minutes
                    if($influencer->updated_at->diffInMinutes(Carbon::now()->subMinutes(10)) === 0){
                        $ignoreInstagram = true;
                        continue;
                    }
                        
                    $this->info("Update Instagram influencer @{$influencer->username}");
                    
                    foreach($influencer->posts as $post){
                        // Get online media
                        $media = $this->instagramScraper->getMedia($post->short_code);
                        $this->info("Post {$media['short_code']} successfully scraped!");

                        // Update comments if post linked to a tracker
                        $mediaTrackersCount = TrackerInfluencerMedia::where('influencer_post_id', $influencerMedia->id)->count();
                        if($mediaTrackersCount > 0){
                            $sentiments = $this->instagramScraper->analyzeMedia($media);
                            $media = array_merge($media, $sentiments);
                        }

                        // Update local media
                        $files = $media['files'];
                        unset($media['files']);
                        $post->update($media);

                        // Update media assets
                        array_walk($files, function($file) use ($post){
                            if(empty($file) || is_null($file) || !is_array($file))
                                return;
                
                            // Push added media record
                            $file = array_merge($file, ['post_id' =>  $post->id]);
                            InfluencerPostMedia::updateOrCreate(['post_id' => $file['post_id'], 'file_id' => $file['file_id']], $file);
                        });

                        $this->info("Post {$post->short_code} successfully updated.");
                    }
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
