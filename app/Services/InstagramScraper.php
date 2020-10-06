<?php

namespace App\Services;

use Format;
use Exception;
use Carbon\Carbon;
use App\Influencer;
use Illuminate\Http\UploadedFile;
use Unirest\Request;
use InstagramScraper\Instagram;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Phpfastcache\Helper\Psr16Adapter;
use Sentiment\Analyzer;

class InstagramScraper
{
    /**
     * Instagram scraper
     * 
     * @var InstagramScraper\Instagram
     */
    private $instagram;

    public function __construct()
    {
        // Disable SSL Certif
        if(config("app.debug"))
            Request::verifyPeer(false);

        // Init instagram scraper
        try{
            $this->instagram = Instagram::withCredentials(env("INSTAGRAM_ACCOUNT"), env("INSTAGRAM_PASSWORD"), new Psr16Adapter('Files'));
            $this->instagram->login();
        }catch(Exception $ex){
            // Trace log
            Log::error($ex->getMessage());

            $this->instagram = new Instagram();
        }
    }

    public function setProxy()
    {
        // Get random proxies list
        $proxies = file_get_contents("https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=5000&country=US&anonymity=elite&ssl=yes");
        $list = explode(PHP_EOL, trim($proxies));

        // Test and get valid proxy
        $proxy = $this->testProxy($list);
        if(!isset($proxy['ip'], $proxy['port']))
            return;
        
        // Set proxy
        $this->instagram->setProxy([
            'address' => $proxy['ip'],
            'port'    => $proxy['port']
        ]);
    }

    /**
     * Scrap user details by username
     * 
     * @param string $username
     * @return array
     */
    public function byUsername(string $username) : array
    {
        // Scrap user
        $account = collect($this->instagram->getAccount($username));

        // Format account
        $data = Format::parseArrayASCIIKey($account);

        return $data->toArray();
    }

    /**
     * Scrap user medias
     * 
     * @param Influencer $influencer
     * @return array
     */
    public function getMedias(Influencer $influencer, $maxID = null, array $data = []) : array
    {
        // Scrap medias
        $instaMedias = $this->instagram->getPaginateMedias($influencer->username, $maxID);
        foreach($instaMedias['medias'] as $media){
            // Calculate video duration
            $videoDuration = null;
            // if($media->getType() === 'video' && $media->getVideoDuration() === '' && !empty($media->getVideoStandardResolutionUrl())){
            //     Storage::disk('local')->put('/tmp/' . $media->getShortCode(), file_get_contents($media->getVideoStandardResolutionUrl()));
            //     $video = new GetId3(new UploadedFile(Storage::disk('local')->path('/tmp/' . $media->getShortCode()), $media->getShortCode()));
            //     $videoDuration = $video->getPlaytimeSeconds();
            //     Storage::disk('local')->delete('/tmp/' . $media->getShortCode());
            // }

            // Handle comments sentiments
            $positive = $neutral = $negative = 0;
            // if($media->getCommentsCount() > 0){
            //     $sentiment = $this->getCommentsSentiment($media->getId(), $media->getCommentsCount());
            //     $positive = $sentiment['positive'];
            //     $neutral = $sentiment['neutral'];
            //     $negative = $sentiment['negative'];
            // }

            // Format data
            array_push($data, [
                'influencer_id' =>  $influencer->id,
                'post_id'       =>  $media->getId(),
                'link'          =>  $media->getLink(),
                'short_code'    =>  $media->getShortCode(),
                'type'          =>  $media->getType(),
                'likes'         =>  $media->getLikesCount(),
                'thumbnail_url' =>  $media->getImageThumbnailUrl(),
                'comments'      =>  $media->getCommentsCount(),
                'published_at'  =>  Carbon::parse($media->getCreatedTime()),
                'caption'       =>  $media->getCaption(),
                'alttext'       =>  $media->getAltText(),
                'location'      =>  $media->getLocationName(),
                'location_id'   =>  $media->getLocationId(),
                'location_slug' =>  $media->getLocationSlug(),
                'video_views'   =>  $media->getVideoViews(),
                'video_duration'=>  $videoDuration,
                'is_ad'         =>  $media->isAd(),
                'comments_disabled' =>  $media->getCommentsDisabled(),
                'caption_edited'    =>  $media->isCaptionEdited(),
                'comments_positive' =>  $positive,
                'comments_neutral'  =>  $neutral,
                'comments_negative' =>  $negative,
            ]);
        }

        return $instaMedias['hasNextPage'] ? $this->getMedias($influencer, $instaMedias['maxId'], $data) : $data;
    }

    public function getCommentsSentiment($mediaID, $max, array $data = ['positive' => 0, 'neutral' => 0, 'negative' => 0])
    {
        // Set proxy
        //$this->setProxy();

        // Load comments
        $comments = $this->instagram->getMediaCommentsById($mediaID, $max);
        if(sizeof($comments) === 0)
            return $data;
            
        foreach($comments as $comment){
            // Analyze sentiment
            $analyzer = new Analyzer();
            $sentiment = $analyzer->getSentiment($comment->getText());
            $data['positive'] += $sentiment['pos'];
            $data['neutral'] += $sentiment['neu'];
            $data['negative'] += $sentiment['neg'];
        }

        // TODO: calcul sentiment for child comments

        return [
            'positive'  => round($data['positive'] / sizeof($comments), 2),
            'neutral'   => round($data['neutral'] / sizeof($comments), 2),
            'negative'  => round($data['negative'] / sizeof($comments), 2),
        ]; 
    }

    /**
     * Scrap instagram stories for an username
     * 
     * @param string $username
     * @return array
     */
    public function getStories(string $username)
    {
        // Scrap user
        $stories = collect($this->instagram->getStories($username));

        // Format account
        $data = Format::parseArrayASCIIKey($stories);

        return $data->toArray();
    }

    /**
     * Test proxy is online
     * 
     * @param array $proxiesList
     * @return array
     */
    private function testProxy(array $proxiesList)
    {
        // Validate proxies
        foreach($proxiesList as $proxy){
            if(!preg_match('/^\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b:\d{2,5}/', $proxy))
                continue;

            $proxy = explode(':', $proxy);
            if(!isset($proxy[0], $proxy[1]))
                continue;

            $waitTimeoutInSeconds = 60; 
            if($fp = @fsockopen($proxy[0], $proxy[1], $errCode, $errStr, $waitTimeoutInSeconds)){   
                return [
                    'ip'    =>  $proxy[0],
                    'port'  =>  $proxy[0]
                ];
            }
        }

        return [];
    }
}