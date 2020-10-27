<?php

namespace App\Jobs;

use App\Influencer;
use Illuminate\Bus\Queueable;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ScrapInstagramAllPostsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 0;

    /**
     * Influencer
     * 
     * @var \App\Influencer
     */
    private $influencer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Influencer $influencer)
    {
        // Init
        $this->influencer = $influencer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(InstagramScraper $scraper)
    {
        try{
            // Verify last fetch
            if(!in_array($this->influencer->queued, ['finished', 'failed'])){
                // Set influencer queue as on progress
                $this->influencer->update(['queued' => 'progress']);
                Log::info("Progress influencer ID: {$this->influencer->id}");

                // Update influencer posts
                Log::info("Number of posts: " . $this->influencer->posts);
                Log::info("Please wait until scraping all medias ...");
                $scraper->getMedias($this->influencer);

                if($this->influencer->posts()->count() == $this->influencer->posts)
                    $this->tracker->update(['queued' => 'finished']);
            }
        }catch(\Exception $ex){
            // Trace the error
            $this->fail($ex);
        }
    }

    public function fail($exception = null)
    {
        $this->influencer->update(['queued' => 'failed']);
        Log::info("Fail to scrap influencer ID: {$this->influencer->id}");

        Log::error($exception->getMessage());
    }
}
