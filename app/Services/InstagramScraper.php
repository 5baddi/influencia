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
        $instaMedias = $this->instagram->getPaginateMedias($influencer->username, $maxID);
        foreach($instaMedias['medias'] as $media){
            // TODO: Handle comments sentiments

            // Get media files 
            $files = [];
            if(in_array($media->getType(), ['sidecar', 'carousel'])){
                $files = array_map(function($file){
                    $this->getFile($file);
                },  ($media->getType() === 'sidecar' ? $media->getSidecarMedias() : $media->getCarouselMedia()));
            }else{
                $files = $this->getFile($media);
            }
            
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
                'location_json' =>  $media->getLocationAddressJson(),
                'video_views'   =>  $media->getVideoViews(),
                'video_duration'=>  $this->getVideoDuration($media),
                'is_ad'         =>  $media->isAd(),
                'comments_disabled' =>  $media->getCommentsDisabled(),
                'caption_edited'    =>  $media->isCaptionEdited(),
                'files'             =>  $files
            ]);
        }

        return $instaMedias['hasNextPage'] ? $this->getMedias($influencer, $instaMedias['maxId'], $data) : $data;
    }

    /**
     * Scrap media details
     * 
     * @param string $mediaShortCode
     * @return array
     */
    public function getMedia(string $mediaShortCode) : array
    {
        // Scrap media
        $media = $this->instagram->getMediaByCode($mediaShortCode);

        // Format media
        return [
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
            'caption_edited'    =>  $media->isCaptionEdited()
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
        $stories = collect($this->instagram->getStories([$username]));

        // Format account
        $data = Format::parseArrayASCIIKey($stories);

        return $data->toArray();
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
            'type'  =>  $media->getType(),
            'url'   =>  $url,
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
        if($media->getType() === 'video' && $media->getVideoDuration() === '' && !empty($media->getVideoStandardResolutionUrl())){
            Storage::disk('local')->put('/tmp/' . $media->getShortCode(), file_get_contents($media->getVideoStandardResolutionUrl()));
            $video = new GetId3(new UploadedFile(Storage::disk('local')->path('/tmp/' . $media->getShortCode()), $media->getShortCode()));
            Storage::disk('local')->delete('/tmp/' . $media->getShortCode());

            return $video->getPlaytimeSeconds();
        }

        return null;
    }

    /**
     * Get media sentiments and emojis from comments
     * 
     * @param \InstagramScraper\Model\Media $media
     * @return null|array
     */
    private function getSentimentsAndEmojis(\InstagramScraper\Model\Media $media) : ?array
    {
        if($media->getCommentsCount() === 0)
            return null;

        // init
        $data = ['comments_positive' => 0, 'comments_neutral' => 0, 'comments_negative' => 0, 'comments_emojis' => null];

        // Scrap comments
        $sentiment = $this->getCommentsSentiment($media, 100, $data);

        // Get top 3 emojis
        if(!is_null($sentiment['emojis']) && !empty($sentiment['emojis'])){
            $data['emojis'] = $this->getTopEmojis($sentiment['emojis']);
            // Format unicode for DB saving
            $data['emojis'] = json_encode($sentiment['emojis'], JSON_PRETTY_PRINT);
        }

        return $data;
    }

    /**
     * Get Emojis from comment text
     * 
     * @param string $comment
     * @return null|array
     */
    private function getCommentEmojis(string $comment) : ?array
    {
        // Ignore empty text
        if(empty($comment))
            return null;

        // Parse emojis
        $emojis = $this->emojiParser->matchAll($comment);

        // Ignore empty emojis list
        if(empty($emojis))
            return null;        

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

        // Extract occurrence of each duplicate emoji
        // Get emojis count and set values as keys 
        $_emojis = array_flip(array_count_values($emojis));
        // Sort emojis by top count
        krsort($_emojis);

        return array_slice($_emojis, 0, $max, true);
    }

    private function getCommentsSentiment(\InstagramScraper\Model\Media $media, $max, array &$data)
    {
        dd($max, $data);
        // Init vars
        $emojis = [];

        // Load comments
        $comments = $this->instagram->getMediaCommentsById($media->getId(), $max);
        if(sizeof($comments) === 0)
            return $data;
            
        foreach($comments as $key => $comment){
            // Analyze sentiment
            $analyzer = new Analyzer();
            $sentiment = $analyzer->getSentiment($comment->getText());
            $data['positive'] += $sentiment['pos'];
            $data['neutral'] += $sentiment['neu'];
            $data['negative'] += $sentiment['neg'];

            // Match all emojis
            array_push($emojis, $this->getCommentEmojis($comment->getText()));

            // Scrap more comments 
            if($key === array_key_last($comments))
                return $this->getCommentsSentiment($media, $max, $data);
        }

        return [
            'positive'  =>  round($data['positive'] / sizeof($media->getCommentsCount()), 2),
            'neutral'   =>  round($data['neutral'] / sizeof($media->getCommentsCount()), 2),
            'negative'  =>  round($data['negative'] / sizeof($media->getCommentsCount()), 2),
            'emojis'    =>  $emojis
        ]; 
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