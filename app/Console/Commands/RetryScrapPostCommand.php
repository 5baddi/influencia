<?php

namespace App\Console\Commands;

use App\Tracker;
use Carbon\Carbon;
use App\Jobs\ScrapPostJob;
use Illuminate\Console\Command;

class RetryScrapPostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:retry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retry failed scrap post jobs';

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
     * @return mixed
     */
    public function handle()
    {
        // Init start at time
        $startTaskAt = microtime(true);
        $this->info("=== Start retry failed scrap post jobs ===");

        // Get failed trackers
        $trackers = Tracker::where('queued', 'failed')->get();
        $this->info("Failed jobs: {$trackers->count()}");

        foreach($trackers as $tracker){
            // Update tracker queued status
            $tracker->update(['queued', 'pending']);
            $this->info("Re-send tracker ID: {$tracker->id}");

            // Put tracker in the queue
            ScrapPostJob::dispatch($tracker)->onQueue('trackers')->delay(Carbon::now()->addSeconds(60));
        }

        $this->info("=== Done ===");
        $endTaskAt = microtime(true) - $startTaskAt;
        $this->info("Total Execution Time: " . Carbon::createFromTimestamp($endTaskAt)->toTimeString());
    }
}
