<?php

namespace App\Jobs;

use Format;
use App\Tracker;
use Carbon\Carbon;
use App\Influencer;
use App\InfluencerPost;
use App\BrandInfluencer;
use App\TrackerInfluencer;
use App\InfluencerPostMedia;
use Illuminate\Bus\Queueable;
use App\TrackerInfluencerMedia;
use App\Services\YoutubeScraper;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ScrapPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 0;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 3600;

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
    public function handle(InstagramScraper $instagram, YoutubeScraper $youtube)
    {
        try{
            // Verify tracker is not deleted yet
            $exists = Tracker::where('id', $this->tracker->id)->exists();
            if(!$exists)
                throw new \Exception("Tracker not exists any more! Maybe it's deleted");

            // Check tracker type
            if($this->tracker->type !== 'post' || is_null($this->tracker->url))
                throw new \Exception("Invalid tracker type or URL's incorrect!");

            // Set tracker on progress status
            $this->tracker->update(['queued' => 'progress']);

            if($this->tracker->platform === "instagram")
                $this->handleInstagram($instagram);
            elseif($this->tracker->platform === "youtube")
                $this->handleYoutube($youtube);

            // Set tracker as finished
            $this->tracker->update(['queued' => 'finished']);
        }catch(\Exception $ex){
            $this->fail($ex);
        }
    }

    /**
     * On job failed
     *
     * @param \Exception|null $exception
     * @return void
     */
    public function fail($exception = null)
    {
        // Trace 
        Log::error("Failed to extract Post info" . !is_null($exception) ? ' | ' . $exception->getMessage() : null);

        // Set tracker as pending until retry
        $this->tracker->update(['queued' => 'failed']);
    }

    /**
     * Parse multi URLS's
     * 
     * @return array
     */
    private function parseURLs() : array
    {
        // Explode url's
        if(strpos($this->tracker->url, ';') !== false)
            return explode(';', $this->tracker->url);
        
        return [$this->tracker->url];
    }

    /**
     * Handle Instagram media or story
     * 
     * @param \App\Services\InstagramScraper $instagram
     * @return void
     */
    private function handleInstagram(InstagramScraper $instagram) : void
    {
        // Disable console debugging
        InstagramScraper::disableDebugging();

        // Sleep for short time
        InstagramScraper::isHTTPRequest();

        // Parse URL's
        $_urls = $this->parseURLs();
        
        // Scrap media details and update on DB
        foreach($_urls as $url){
            $shortCode = Format::extractInstagarmShortCode($url);
            if(is_null($shortCode))
                continue;

            // Verify if media already exists
            $influencerMedia = InfluencerPost::where('short_code', $shortCode)->first();

            // Scrap media details
            $media = $instagram->byMedia($shortCode);
            if(!is_object($media) || is_null($media->getOwner()) || is_null($media->getOwner()->getId()))
                continue;

            // Scrap User details
            $accountDetails = $instagram->byId($media->getOwner()->getId());

            // Check influencer if already exists
            $influencer = Influencer::where('account_id', $media->getOwner()->getId())->first();
            if(is_null($influencer))
                $influencer = Influencer::create($accountDetails);
            else
                $influencer->update($accountDetails);

            // Store influencer picture locally
            if(isset($account, $account->pic_url))
                    $account->pic_url = Format::storePicture($account->pic_url);

            // Load tracker user
            $this->tracker->load('user');
            // Set influencer to active brand
            if(isset($this->tracker->user->selected_brand_id)){
                $existsInBrand = BrandInfluencer::where([
                    'brand_id'      =>  $this->tracker->user->selected_brand_id,
                    'influencer_id' =>  $influencer->id
                ])->first();

                // Check already exists in the same brand
                if(is_null($existsInBrand)){
                    BrandInfluencer::create([
                        'brand_id'      =>  $this->tracker->user->selected_brand_id,
                        'influencer_id' =>  $influencer->id
                    ]);
                }
            }

            //  Analyze media
            $_media = $instagram->getMedia($media);
            $sentiments = $instagram->analyzeMedia($_media);
            $_media = array_merge($_media, $sentiments);

            // Store media
            $_media['influencer_id'] = $influencer->id;

            // Store media thumbnail locally
            if(isset($accountDetails, $accountDetails['thumbnail_url']))
                $accountDetails['thumbnail_url'] = Format::storePicture($accountDetails['thumbnail_url'], "influencers/instagram/thumbnails/");

            // Update or create media
            if(is_null($influencerMedia))
                $influencerMedia = InfluencerPost::create($_media);
            else
                $influencerMedia->update($_media);

            // Store media assets 
            // array_walk($_media['files'], function($file) use ($influencerMedia){
            //     if(empty($file) || is_null($file) || !is_array($file))
            //         return;
    
            //     // Push added media record
            //     $file = array_merge($file, ['post_id' =>  $influencerMedia->id]);
            //     InfluencerPostMedia::updateOrCreate(['post_id' => $file['post_id'], 'file_id' => $file['file_id']], $file);
            // });

            // Update tracker influencers list
            $influencerExists = TrackerInfluencer::where(['tracker_id' => $this->tracker->id, 'influencer_id' => $influencerMedia->influencer_id])->first();
            if(is_null($influencerExists))
                TrackerInfluencer::create(['tracker_id' => $this->tracker->id, 'influencer_id' => $influencerMedia->influencer_id]);

            // Set tracker to media
            $mediaTracker = TrackerInfluencerMedia::where(['tracker_id' => $this->tracker->id, 'influencer_post_id' => $influencerMedia->id])->first();
            if(is_null($mediaTracker))
                TrackerInfluencerMedia::create(['tracker_id' => $this->tracker->id, 'influencer_post_id' => $influencerMedia->id]);
        }
    }

    /**
     * Handle Youtube video
     * 
     * @param \App\Services\YoutubeScraper $youtube
     * @return void
     */
    private function handleYoutube(YoutubeScraper $youtube) : void
    {
        // Disable console debugging
        YoutubeScraper::disableDebugging();

        // Parse URL's
        $_urls = $this->parseURLs();

        // Scrap video details and update on DB
        foreach($_urls as $url){
            // Verify media url
            $videoID = $youtube->extractVideoID($url);
            if(is_null($videoID))
                continue;

            // Verify if video already exists
            $influencerVideo = InfluencerPost::where('short_code', $videoID)->first();

            // Get video details
            $video = $youtube->getVideoByID($url);

            // Get channel details
            $channel = $youtube->getChannelByID($video['channel_id']);

            // Check influencer if already exists
            $influencer = Influencer::where('account_id', $channel['account_id'])->first();
            if(is_null($influencer))
                $influencer = Influencer::create($channel);
            else
                $influencer->update($channel);

            // Store influencer picture locally
            if(isset($account, $account->pic_url))
                $account->pic_url = Format::storePicture($account->pic_url);

            // Load tracker user
            $this->tracker->load('user');
            // Set influencer to active brand
            if(isset($this->tracker->user->selected_brand_id)){
                $existsInBrand = BrandInfluencer::where([
                    'brand_id'      =>  $this->tracker->user->selected_brand_id,
                    'influencer_id' =>  $influencer->id
                ])->first();

                // Check already exists in the same brand
                if(is_null($existsInBrand)){
                    BrandInfluencer::create([
                        'brand_id'      =>  $this->tracker->user->selected_brand_id,
                        'influencer_id' =>  $influencer->id
                    ]);
                }
            }

            // Update or create video
            $video['influencer_id'] = $influencer->id;
            if(is_null($influencerVideo))
                $influencerVideo = InfluencerPost::create($video);
            else
                $influencerVideo->update($video);

            // Update tracker influencers list
            $influencerExists = TrackerInfluencer::where(['tracker_id' => $this->tracker->id, 'influencer_id' => $influencerVideo->influencer_id])->first();
            if(is_null($influencerExists))
                TrackerInfluencer::create(['tracker_id' => $this->tracker->id, 'influencer_id' => $influencerVideo->influencer_id]);

            // Set tracker to video
            $videoTracker = TrackerInfluencerMedia::where(['tracker_id' => $this->tracker->id, 'influencer_post_id' => $influencerVideo->id])->first();
            if(is_null($videoTracker))
                TrackerInfluencerMedia::create(['tracker_id' => $this->tracker->id, 'influencer_post_id' => $influencerVideo->id]);
        }            
    }
}
