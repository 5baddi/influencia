<?php

namespace App\Jobs;

use App\Influencer;
use App\Repositories\InfluencerRepository;
use App\Services\InstagramScraper;
use App\Tracker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Format;

class ScrapInstagramJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Tracker entity
     *
     * @var \App\Tracker
     */
    private $tracker;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(InstagramScraper $scraper, InfluencerRepository $influencerRepo)
    {
        // Refresh tracker
        $this->tracker->refresh();

        // Update analytics for instagram media
        if($this->tracker->type === 'post' && !is_null($this->tracker->url)){
            // Scrap media details
            $media = $scraper->byMedia($this->tracker->url);
            sleep(3);
            if(!is_array($media) || sizeof($media) === 0)
                return $this->fail();

            // Check influencer if already exists
            $influencer = Influencer::where('account_id', $media['owner']->getId())->first();
            // Store influencer if not exists
            if(is_null($influencer))
                $influencer = $influencerRepo->create(Format::parseArrayASCIIKey(collect($media['owner'])));

            // TODO: store media analytics
        }
    }
}
