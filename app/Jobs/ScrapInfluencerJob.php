<?php

namespace App\Jobs;

use Format;
use App\User;
use App\Influencer;
use Illuminate\Bus\Queueable;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\CreateInfluencerJobState;

class ScrapInfluencerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * User to be notified
     * 
     * @var \App\User
     */
    private $user;


    /**
     * Instagram username
     * 
     * @var string
     */
    public $username;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 3600;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, string $username)
    {
        $this->user = $user;
        $this->username = $username;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(InstagramScraper $instagram)
    {
        try{
            // Disable console debugging
            InstagramScraper::disableDebugging();

            // Sleep for short time
            InstagramScraper::isHTTPRequest();

            if(preg_match('/^[0-9]*$/', $this->username) && filter_var($this->username, FILTER_VALIDATE_INT) !== false)
                $account = $instagram->byId((int)$this->username);
            else
                $account = $instagram->byUsername($this->username);

            if(isset($account, $account['pic_url'])){
                // Store influencer picture locally
                $account['pic_url'] = Format::storePicture($account['pic_url']);

                // Store account
                $influencer = Influencer::create($account);
            }
        }catch(\Exception $exception){
            Log::error("Failed to extract Influencer info" . !is_null($exception) ? ' | ' . $exception->getMessage() : null);
        }

        // Notify user
        $this->user->notify(new CreateInfluencerJobState($this->user, $this->username, $influencer ?? null));
    }
}
