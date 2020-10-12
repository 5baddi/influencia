<?php

namespace App\Jobs;

use App\Influencer;
use App\Repositories\InfluencerPostRepository;
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
    public function handle(InstagramScraper $scraper, InfluencerRepository $influencerRepo, InfluencerPostRepository $postRepo)
    {
        // Refresh tracker
        $this->tracker->refresh();

        // Update analytics for instagram media
        if($this->tracker->type === 'post' && !is_null($this->tracker->url)){
            // Scrap media details
            $media = $scraper->byMedia($this->tracker->url);
            sleep(3);
            if(!is_array($media) || sizeof($media) === 0 || !isset($media['owner']) || is_null($media['owner']->getId()))
                return $this->fail();

            // Check influencer if already exists
            $influencer = Influencer::where('account_id', $media['owner']->getId())->first();
            // Parse owner data
            $owner = Format::parseArrayASCIIKey(collect($media['owner']));
            $owner = $owner->toArray();
            // Store influencer if not exists
            if(is_null($influencer))
                $influencer = $influencerRepo->create($owner);
            else
                $influencer = $influencerRepo->update($influencer, $owner);

            // Store media analytics
            $instaMedias = $scraper->getMedias($influencer);
            sleep(3);
            foreach($instaMedias as $media){
                // Update exists row
                $existsMedia = $this->postRepo->exists($influencer, $media['post_id']);
                if(!is_null($existsMedia)){
                    $this->postRepo->update($existsMedia, $media);
                    continue;
                }
                $this->postRepo->create($media);

                sleep(3);
            }
        }
    }
}
