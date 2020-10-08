<?php

namespace App\Services;

use App\Helpers\EmojiParser;
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

    /**
     * Emoji parser
     * 
     * @var App\Helpers\EmojiParser
     */
    private $emojiParser;

    public function __construct(EmojiParser $emojiParser)
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

        // Init emoji parser
        $this->emojiParser = $emojiParser;
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
     * @param int $maxID
     * @param array $data
     * @return array
     */
    public function getMedias(Influencer $influencer, $maxID = null, array &$data = []) : array
    {
        // Scrap medias
        $instaMedias = $this->instagram->getPaginateMediasByUserId($influencer->account_id, 10);
        sleep(3);
        
        foreach($instaMedias['medias'] as $media){
            // Scrap media
            $_media = $this->getMedia($media->getShortCode(), $media);
            $_media['influencer_id'] = $influencer->id;  
        
            // Format data
            array_push($data, $_media);
        }

        return $instaMedias['hasNextPage'] ? $this->getMedias($influencer, $instaMedias['maxId'], $data) : $data;
    }

    /**
     * Scrap media details
     * 
     * @param string $mediaShortCode
     * @param \InstagramScraper\Model\Media $media
     * @return array
     */
    public function getMedia(string $mediaShortCode, \InstagramScraper\Model\Media $media = null) : array
    {
        // Scrap media
        if(is_null($media)){
            $media = $this->instagram->getMediaByCode($mediaShortCode);
            sleep(3);
        }

        // Fetch comments sentiments
        $comments = [];
        $this->getSentimentsAndEmojis($media, $comments);

        // Add media and comments details
        $_media = [
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
            'location_json' =>  $media->getLocationAddressJson(),
            'video_views'   =>  $media->getVideoViews(),
            'video_duration'=>  $this->getVideoDuration($media),
            'is_ad'         =>  $media->isAd(),
            'comments_disabled' =>  $media->getCommentsDisabled(),
            'caption_edited'    =>  $media->isCaptionEdited(),
            'files'             =>  $this->getFiles($media)
        ];

        return array_merge($_media, $comments);
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
        $stories = collect($this->instagram->getStories([$username]));

        // Format account
        $data = Format::parseArrayASCIIKey($stories);

        return $data->toArray();
    }

    /**
     * Get files for a media
     * 
     * @param \InstagramScraper\Model\Media $media
     * @return null|array
     */
    private function getFiles(\InstagramScraper\Model\Media $media) : ?array
    {
        // Get media files 
        $files = [];
        if(in_array($media->getType(), ['sidecar', 'carousel'])){
            $files = array_map(function($file){
                return $this->getFile($file);
            },  ($media->getType() === 'sidecar' ? $media->getSidecarMedias() : $media->getCarouselMedia()));
        }else{
            $files = $this->getFile($media);
        }

        return $files;
    }
    
    /**
     * Get file from media
     * 
     * @param \InstagramScraper\Model\Media $media
     * @return null|array
     */
    private function getFile(\InstagramScraper\Model\Media $media) : ?array
    {
        if(empty($media) || is_null($media))
            return null;

        // Init URL
        $url = null;

        if($media->getType() === 'image'){
            $url = $media->getImageHighResolutionUrl() ?? $media->getImageStandardResolutionUrl();
        }elseif($media->getType() === 'video'){
            $url = $media->getVideoStandardResolutionUrl() ?? $media->getVideoLowResolutionUrl();
        }

        return [
            'file_id'   =>  $media->getId(),
            'type'      =>  $media->getType(),
            'url'       =>  $url,
        ];
    }

    /**
     * Get video duration
     * 
     * @param \InstagramScraper\Model\Media $media
     * @return null|int
     */
    private function getVideoDuration(\InstagramScraper\Model\Media $media) : ?int
    {
        if($media->getType() === 'video' && $media->getVideoDuration() === ''){
            Storage::disk('local')->put('/tmp/' . $media->getShortCode(), file_get_contents($media->getVideoStandardResolutionUrl() ?? $media->getVideoStandardResolutionUrl()));
            $video = new GetId3(new UploadedFile(Storage::disk('local')->path('/tmp/' . $media->getShortCode()), $media->getShortCode()));
            $duration = $video->getPlaytimeSeconds();
            Storage::disk('local')->delete('/tmp/' . $media->getShortCode());

            return $duration;
        }

        return null;
    }

    /**
     * Get media sentiments and emojis from comments
     * 
     * @param \InstagramScraper\Model\Media $media
     * @return null|array
     */
    private function getSentimentsAndEmojis(\InstagramScraper\Model\Media $media, array &$data, int $nextComment = null, $max = 100) : ?array
    {
        // init
        $data = ['comments_positive' => 0, 'comments_neutral' => 0, 'comments_negative' => 0, 'comments_emojis' => []];

        // Ignore media with disabled comments option
        if($media->getCommentsCount() === 0 || $media->getCommentsDisabled())
            return $data;


        // Load comments
        $comments = $this->instagram->getPaginateMediaCommentsById($media->getId(), $max);
        sleep(3);
            
        foreach($comments['comments'] as $comment){
            // Analyze sentiment
            $analyzer = new Analyzer();
            $sentiment = $analyzer->getSentiment($comment->getText());
            $data['comments_positive'] += $sentiment['pos'];
            $data['comments_neutral'] += $sentiment['neu'];
            $data['comments_negative'] += $sentiment['neg'];

            // Match all emojis
            $data['comments_emojis'] = array_merge($data['comments_emojis'], $this->getCommentEmojis($comment->getText()));

            // Scrap more comments 
            // if($key === array_key_last($comments) && sizeof($data) < $media->getCommentsCount())
                // return $this->getCommentsSentiment($media, $max, $comment->getChildCommentsNextPage(), $data);
        }

        // Get more comments
        if(isset($comments['haseNextPage']) && !is_null($comments['maxId']))
            return $this->getSentimentsAndEmojis($media, $data, $comments['maxId'], $max);


        // Get top 3 emojis
        if(isset($data['comments_emojis']) && !empty($data['comments_emojis'])){
            $data['comments_emojis'] = $this->getTopEmojis($data['comments_emojis']);
            // Sort top emojis
            krsort($data['comments_emojis']);
            // Format unicode for DB saving
            $data['comments_emojis'] = json_encode($data['comments_emojis'], JSON_PRETTY_PRINT);
        }

        return [
            'comments_positive'  =>  round($data['comments_positive'] / $media->getCommentsCount(), 2),
            'comments_neutral'   =>  round($data['comments_neutral'] / $media->getCommentsCount(), 2),
            'comments_negative'  =>  round($data['comments_negative'] / $media->getCommentsCount(), 2),
            'comments_emojis'    =>  $data['comments_emojis']
        ]; 
    }

    /**
     * Get Emojis from comment text
     * 
     * @param string $comment
     * @return array
     */
    private function getCommentEmojis(string $comment) : array
    {
        // Ignore empty text
        if(empty($comment))
            return [];

        // Parse emojis
        $emojis = $this->emojiParser->matchAll($comment);

        // Ignore empty emojis list
        if(empty($emojis))
            return [];        

        // Slice empty emoji
        array_walk($emojis, function($item, $key) use (&$emojis){
            if(is_null($item) || empty($item))
                unset($emojis[$key]);
        });

        return $emojis;
    }

    /**
     * Get top emojis
     * 
     * @param array $emojis
     * @param int $max
     * @return null|array
     */
    private function getTopEmojis(array $emojis, int $max = 3) : ?array
    {
        // Ignore empty emojis list
        if(is_null($emojis) || empty($emojis))
            return null;

        // Extract occurrence of each duplicate emoji and set values as keys 
        $_emojis = array_flip(array_count_values($emojis));

        return array_slice($_emojis, 0, $max, true);
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