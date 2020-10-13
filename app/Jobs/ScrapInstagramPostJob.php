<?php

namespace App\Jobs;

use App\Tracker;
use App\Influencer;
use Illuminate\Bus\Queueable;
use App\Services\InstagramScraper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\InfluencerRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Console\Output\ConsoleOutput;

class ScrapInstagramPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Tracker entity
     *
     * @var \App\Tracker
     */
    private $tracker;

    /**
     * Console output
     * 
     * @var \Symfony\Component\Console\Output\ConsoleOutput
     */
    private $console;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;

        // Init console
        $this->console = new ConsoleOutput();
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
            if(!is_array($media) || sizeof($media) === 0 || !isset($media['owner']) || is_null($media['owner']->getId()))
                return $this->fail();

            // Check influencer if already exists
            $influencer = Influencer::where('account_id', $media['owner']->getId())->first();
            // Parse owner data
            $owner = $scraper->byUsername($media['owner']->getUsername());
            // Store influencer if not exists
            if(is_null($influencer)){
                $influencer = $influencerRepo->create($owner);
                // $this->console->writeln("<fg=green>Create influencer @{$influencer->username}</>");
            }else{
                $influencer = $influencerRepo->update($influencer, $owner);
                // $this->console->writeln("<fg=green>Update influencer @{$influencer->username}</>");
            }

            // Store media analytics
            $instaMedias = $scraper->getMedias($influencer);
            // if(is_array($instaMedias) && sizeof($instaMedias) > 0)
                // $this->console->writeln("<fg=green>Successfully updated " . sizeof($influencerRepo) . " posts</>");
        }
    }
}
