<?php

namespace App\Console\Commands;

use App\Tracker;
use Carbon\Carbon;
use App\TrackerInfluencer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TrackersUpdaterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updater:trackers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update trackers queued status and other details';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $this->info("=== Start updating trackers ===");
            $startTaskAt = microtime(true);

            // Update trackers details & analytics
            $this->updateTrackers();

            $this->info("=== Done ===");
            $endTaskAt = microtime(true) - $startTaskAt;
            $this->info("Total Execution Time: " . Carbon::createFromTimestamp($endTaskAt)->toTimeString());

            return 1;
        }catch(\Exception $exception){
            Log::error($exception->getMessage(), ['context' => 'Trackers updater with code: ' . $exception->getCode()]);
            $this->error($exception->getMessage());

            return 0;
        }
    }

    /**
     * Update trackers details and analytics
     *
     * @return void
     */
    private function updateTrackers() : void
    {
        // Get trackers
        $trackers = Tracker::with(['posts', 'influencers'])->where(['queued' => 'progress', 'status' > true])->get();
        $this->info("Number of trackers to sync: " . $trackers->count());

        // Scrap each tracker details
        foreach($trackers as $tracker){
            // TODO: scrap stories details
            if($tracker->platform === "instagram" && $tracker->type === "story")
                continue;

            if($tracker->platform === "instagram" && $tracker->type === "post"){
                // Init
                $scrapedInfluencers = 0;

                // Update trackers & influencers queued state
                foreach($tracker->posts->load('influencer') as $post){
                    // Set tracker to the post
                    $post->update(['tracker_id' => $tracker->id]);

                    // Update tracker influencers list
                    $influencerExists = TrackerInfluencer::where(['tracker_id' => $tracker->id, 'influencer_id' => $post->influencer->id])->first();
                    if(is_null($influencerExists))
                        TrackerInfluencer::create(['tracker_id' => $tracker->id, 'influencer_id' => $post->influencer->id]);


                    // Update influencer queued status
                    if($post->influencer->posts()->count() == $post->influencer->posts){
                        if($post->influencer->queued !== 'finished')
                            $post->influencer->update(['queued' => 'finished']);

                        ++$scrapedInfluencers;
                    }
                }

                // Refresh tracker
                $tracker = $tracker->refresh();

                // Set tracker queued as finished
                if($tracker->influencers->count() === $scrapedInfluencers && $scrapedInfluencers > 0)
                    $tracker->update(['queued' => 'finished']);
            }
        }
    }
}
