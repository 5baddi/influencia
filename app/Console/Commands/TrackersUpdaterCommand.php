<?php

namespace App\Console\Commands;

use App\Tracker;
use Carbon\Carbon;
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
        $trackers = Tracker::with(['posts', 'influencers'])->where('status', true)->whereNotIn('queued', ['pending', 'finished'])->get();
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
                    if($post->influencer->username === 'safia.tazi')
                    continue;
                    // Update influencer queued status
                    if($post->influencer->posts->count() === $post->influencer->medias)
                        ++$scrapedInfluencers;
                }

                // Set tracker queued as finished
                if($tracker->influencers->count() === $scrapedInfluencers && $scrapedInfluencers > 0)
                    $tracker->update(['queued' => 'finished']);
            }
        }
    }
}
