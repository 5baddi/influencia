<?php

namespace App\Jobs;

use Format;
use App\Tracker;
use App\Influencer;
use App\InfluencerPost;
use App\TrackerInfluencer;
use Illuminate\Bus\Queueable;
use App\Services\InstagramScraper;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\InfluencerRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\InfluencerPostRepository;

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
    public function handle(InstagramScraper $scraper, InfluencerRepository $influencerRepo, InfluencerPostRepository $postRepo)
    {
        // Refresh tracker
        $this->tracker->refresh();

        try{
            // Update analytics for instagram media
            if($this->tracker->type === 'post' && !is_null($this->tracker->url)){
                // Set tracker on progress status
                $this->tracker->update(['queued' => 'progress']);
                $this->tracker = $this->tracker->refresh();

                // Parse URL
                $_url = $this->tracker->url;
                $_urls = [];
                if(strpos($this->tracker->url, ';') !== false){
                    $_urls = explode(';', $this->tracker->url);
                    if(!isset($_urls[0]) || empty($_urls[0]))
                        throw new \Exception("Something going wrong with the posts links!");

                    $_url = $_urls[0];
                }

                // Scrap User details
                $media = $scraper->byMedia($_url);
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
                if(is_null($influencer)){
                    $influencer = $influencerRepo->create($accountDetails);
                }else{
                    $influencer = $influencerRepo->update($influencer, $accountDetails);
                }

                // Update tracker details
                $this->tracker->update([
                    'username'  =>  $influencer->username
                ]);
                $this->tracker = $this->tracker->refresh();

                // Scrap media details and update on DB
                foreach($_urls as $url){
                    if(empty($url) || !isset($url) || $url === "")
                        continue;

                    $this->scrapMediaDetails($url, $scraper, $influencer, $postRepo);
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
        // Set tracker on failed status
        $this->tracker->update(['queued' => 'failed']);

        Log::error("Failed to extract Post info" . !is_null($exception) ? ' | ' . $exception->getMessage() : null);
    }

    private function scrapMediaDetails(string $url, InstagramScraper $scraper, Influencer $influencer, InfluencerPostRepository $postRepo)
    {
        // Format short code
        $shortCode = Format::extractInstagarmShortCode($url);
        if(is_null($shortCode))
            return $this->fail(new \Exception("Can't get post with URL: {$url}"));

        // Verify of already exists
        $existsMedia = InfluencerPost::where('short_code', $shortCode)->first();
        if(is_null($existsMedia)){
            // Scrape media
            $_media = $scraper->getMedia($shortCode);

            // Set media influencer ID
            $_media['influencer_id'] = $influencer->id;
            // Set tracker ID
            $_media['tracker_id'] = $this->tracker->id;

            // Store media
            $postRepo->create($_media);
            Log::info("Create post: {$_media['short_code']}");
        }else{
            // Set tracker ID
            $existsMedia->update(['tracker_id' => $this->tracker->id]);
            Log::info("Update post: {$existsMedia->short_code}");
        }
    }
}
