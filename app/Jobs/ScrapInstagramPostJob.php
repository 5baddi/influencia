<?php

namespace App\Jobs;

use Format;
use App\Tracker;
use Carbon\Carbon;
use App\Influencer;
use App\InfluencerPost;
use App\TrackerInfluencer;
use App\InfluencerPostMedia;
use Illuminate\Bus\Queueable;
use App\TrackerInfluencerMedia;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
    public function handle(InstagramScraper $scraper)
    {
        try{
            // Disable console debugging
            InstagramScraper::disableDebugging();

            // Re-check tracker is exists
            $exists = Tracker::find($this->tracker->id);
            if(is_null($exists))
                return;
            else
                $this->tracker->refresh();

            // Update analytics for instagram media
            if($this->tracker->type === 'post' && !is_null($this->tracker->url)){
                // Set tracker on progress status
                $this->tracker->update(['queued' => 'progress']);

                // Parse URL
                $_urls = [];
                if(strpos($this->tracker->url, ';') !== false)
                    $_urls = explode(';', $this->tracker->url);
                else
                    $_urls = [$this->tracker->url];

                // Scrap media details and update on DB
                foreach($_urls as $url){
                    $shortCode = Format::extractInstagarmShortCode($url);
                    if(is_null($shortCode))
                        continue;

                    // Verify if media already exists
                    $influencerMedia = InfluencerPost::where('short_code', $shortCode)->first();
                    if(is_null($influencerMedia)){
                        // Scrap User details
                        $media = $scraper->byMedia($shortCode);
                        if(!is_object($media) || is_null($media->getOwner()))
                            return $this->fail();

                        // Parse owner data
                        $account = $media->getOwner();
                        $accountDetails = [
                            'account_id'    =>  $account->getId(),
                            'username'      =>  $account->getUsername(),
                            'name'          =>  $account->getFullName(),
                            'pic_url'       =>  $account->getProfilePicUrl(),
                            'biography'     =>  $account->getBiography(),
                            'website'       =>  $account->getExternalUrl(),
                            'followers'     =>  $account->getFollowedByCount(),
                            'follows'       =>  $account->getFollowsCount(),
                            'medias'        =>  $account->getMediaCount(),
                            'is_business'   =>  $account->isBusinessAccount(),
                            'is_private'    =>  $account->isPrivate(),
                            'is_verified'   =>  $account->isVerified(),
                            'highlight_reel'    =>  $account->getHighlightReelCount(),
                            'business_category' =>  $account->getBusinessCategoryName(),
                            'business_email'    =>  $account->getBusinessEmail(),
                            'business_phone'    =>  $account->getBusinessPhoneNumber(),
                            'business_address'  =>  $account->getBusinessAddressJson(),
                        ];

                        // Check influencer if already exists
                        $influencer = Influencer::where('account_id', $account->getId())->first();
                        if(is_null($influencer))
                            $influencer = Influencer::create($accountDetails);

                        //  Analyze media
                        $_media = $scraper->getMedia($media);
                        $sentiments = $scraper->analyzeMedia($_media);
                        $_media = array_merge($_media, $sentiments);

                        // Store media
                        $_media['influencer_id'] = $influencer->id;
                        $influencerMedia = InfluencerPost::create($_media);

                        // Store media assets 
                        array_walk($_media['files'], function($file) use ($influencerMedia){
                            if(empty($file) || is_null($file) || !is_array($file))
                                return;
                
                            // Push added media record
                            $file = array_merge($file, ['post_id' =>  $influencerMedia->id]);
                            InfluencerPostMedia::updateOrCreate(['post_id' => $file['post_id'], 'file_id' => $file['file_id']], $file);
                        });
                    }

                    // Set tracker to media
                    $mediaTracker = TrackerInfluencerMedia::where(['tracker_id' => $this->tracker->id, 'influencer_post_id' => $influencerMedia->id])->first();
                    if(is_null($mediaTracker))
                        TrackerInfluencerMedia::create(['tracker_id' => $this->tracker->id, 'influencer_post_id' => $influencerMedia->id]);

                    // Update tracker influencers list
                    $influencerExists = TrackerInfluencer::where(['tracker_id' => $this->tracker->id, 'influencer_id' => $influencerMedia->influencer_id])->first();
                    if(is_null($influencerExists))
                        TrackerInfluencer::create(['tracker_id' => $this->tracker->id, 'influencer_id' => $influencerMedia->influencer_id]);
                }

                // Set tracker influencer
                $trackerInfluencer = TrackerInfluencer::where(['tracker_id' => $this->tracker->id, 'influencer_id' => $influencer->id])->first();
                if(is_null($trackerInfluencer))
                    TrackerInfluencer::create(['tracker_id' => $this->tracker->id, 'influencer_id' => $influencer->id]);
            }
        }catch(\Exception $ex){
            $this->fail($ex);
        }
    }

    public function fail($exception = null)
    {
        // Trace 
        Log::error("Failed to extract Post info" . !is_null($exception) ? ' | ' . $exception->getMessage() : null);

        // Set tracker on failed status
        $this->tracker->update(['queued' => 'pending']);

        // Dispatch job to run after 10 minutes
        ScrapInstagramPostJob::dispatch($this->tracker)->delay(Carbon::now()->addMinutes(10));
    }
}
