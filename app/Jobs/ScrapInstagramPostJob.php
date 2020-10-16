<?php

namespace App\Jobs;

use Format;
use App\Tracker;
use App\Influencer;
use Illuminate\Bus\Queueable;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\InfluencerRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\InfluencerPostRepository;
use Symfony\Component\Console\Output\ConsoleOutput;

class ScrapInstagramPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

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
    public function handle(InstagramScraper $scraper, InfluencerRepository $influencerRepo, InfluencerPostRepository $postRepo)
    {
        // Refresh tracker
        $this->tracker->refresh();

        // Update analytics for instagram media
        if($this->tracker->type === 'post' && !is_null($this->tracker->url)){
            // Set tracker on progress status
            $this->tracker->update(['queued' => 'progress']);
            $this->tracker = $this->tracker->refresh();

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

            // Update tracker details
            $this->tracker->update([
                'username'  =>  $influencer->username
            ]);
            $this->tracker = $this->tracker->refresh();

            // Format short code
            $shortCode = Format::extractInstagarmShortCode($this->tracker->url);
            if(is_null($shortCode))
                return $this->fail();

            // Store media analytics
            // TODO: verify short code parser
            $_media = $scraper->getMedia($shortCode, $this->tracker);
            // Set media influencer ID
            $_media['influencer_id'] = $influencer->id;
            // Store or update media
            $existsMedia = $postRepo->exists($influencer, $_media['post_id']);
            if(!is_null($existsMedia)){
                // $this->console->writeln("<fg=green>Update post: {$existsMedia->uuid}</>");
                // $this->console->writeln("<href={$existsMedia->link}>{$existsMedia->link}</>");
                $postRepo->update($existsMedia, $_media);
                Log::info("Update post: {$existsMedia->short_code}");
            }else{
                // $this->console->writeln("<fg=green>Create post: {$_media['short_code']}</>");
                // $this->console->writeln("<href={$_media['link']}>{$_media['link']}</>");
                $postRepo->create($_media);
                Log::info("Create post: {$_media['short_code']}");
            }
            // if(is_array($instaMedias) && sizeof($instaMedias) > 0)
                // $this->console->writeln("<fg=green>Successfully updated " . sizeof($influencerRepo) . " posts</>");

            // Set tracker on finished status
            $this->tracker->update(['queued' => 'finished']);
            $this->tracker = $this->tracker->refresh();
        }
    }

    public function fail($exception = null)
    {
        // Set tracker on failed status
        $this->tracker->update(['queued' => 'failed']);
        $this->tracker = $this->tracker->refresh();
    }
}
