<?php

namespace App\Jobs;

use App\User;
use App\Influencer;
use App\BrandInfluencer;
use Illuminate\Bus\Queueable;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\CreateInfluencerJobState;
use InstagramScraper\Model\Story;

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
     * Story insights
     * 
     * @var array
     */
    public $story;

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
    public function __construct(User $user, string $username, array $story = [])
    {
        $this->user = $user;
        $this->username = $username;
        $this->story = $story;
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

            if(isset($account)){
                // Store account
                $influencer = Influencer::create($account);

                // Set to job to in process
                $influencerInProcess = Influencer::where('in_process', true)->first();
                if(is_null($influencerInProcess))
                    $influencer->update(['in_process' => true]);

                // Set influencer to active brand
                if(isset($this->user->selected_brand_id)){
                    BrandInfluencer::firstOrCreate([
                        'brand_id'      =>  $this->user->selected_brand_id,
                        'influencer_id' =>  $influencer->id
                    ]);
                }

                // Handle story
                if(sizeof($this->story) > 0){
                    // Save story
                    $story = Story::create([
                        'influencer_id' =>  $influencer->id,
                        'tracker_id'    =>  $this->story['tracker_id'],
                        'published_at'  =>  $this->story['published_at']
                    ]);
                }
            }

            // Notify user TODO: use websockets
            // $this->user->notify(new CreateInfluencerJobState($this->user, $this->username, $influencer ?? null));
        }catch(\Exception $exception){
            Log::error("Failed to extract Influencer info" . !is_null($exception) ? ' | ' . $exception->getMessage() : null);
        }
    }
}
