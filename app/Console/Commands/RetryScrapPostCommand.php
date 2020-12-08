<?php

namespace App\Console\Commands;

use App\Tracker;
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
        // Get failed trackers
        $trackers = Tracker::where('queued', 'failed')->get();

        foreach($trackers as $tracker){
            // Update tracker queued status
            $tracker->update(['queued', 'pending']);
            
            // Put tracker in the queue
            ScrapPostJob::dispatch($tracker)->onQueue('trackers')->delay(Carbon::now()->addSeconds(60));
        }
    }
}
