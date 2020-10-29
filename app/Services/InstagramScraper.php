<?php

namespace App\Services;

use Format;
use Exception;
use Carbon\Carbon;
use App\Influencer;
use Unirest\Request;
use Sentiment\Analyzer;
use App\Helpers\EmojiParser;
use App\Repositories\InfluencerPostRepository;
use App\Tracker;
use InstagramScraper\Instagram;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Phpfastcache\Helper\Psr16Adapter;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\ConsoleOutput;

class InstagramScraper
{
    /**
     * Max request by each fetch
     */
    const MAX_REQUEST = 100;
    /**
     * Sleep request seconds
     */
    const SLEEP_REQUEST = 2;

    /**
     * Instagram scraper
     * 
     * @var \InstagramScraper\Instagram
     */
    private $instagram;

    /**
     * Emoji parser
     * 
     * @var \App\Helpers\EmojiParser
     */
    private $emojiParser;

    /**
     * Influencer Post repository
     * 
     * @var \App\Repositories\InfluencerPostRepository
     */
    private $postRepo;

    /**
     * Console output
     * 
     * @var \Symfony\Component\Console\Output\ConsoleOutput
     */
    private $console;

    /**
     * All emojis used in media comments
     * 
     * @var array
     */
    public $emojis = [];
    
    /**
     * All hashags used in media
     * 
     * @var array
     */
    public $hashtags = [];

    public function __construct(EmojiParser $emojiParser, InfluencerPostRepository $postRepo)
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

        // Init repositories
        $this->postRepo = $postRepo;

        // Init console
        // $this->console = new ConsoleOutput();
    }

    public function setProxy()
    {
        // Get random proxies list
        // $proxies = file_get_contents("https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=5000&country=US&anonymity=elite&ssl=yes");
        // $list = explode(PHP_EOL, trim($proxies));

        // // Test and get valid proxy
        // $proxy = $this->testProxy($list);
        // if(!isset($proxy['ip'], $proxy['port']))
        //     return;
        
        // // Set proxy
        // $this->instagram->setProxy([
        //     // 'address' => $proxy['ip'],
        //     'address' => '46.246.26.10',
        //     // 'port'    => $proxy['port']
        //     'port'    => '3128'
        // ]);
    }

    /**
     * Scrap user details by username
     * 
     * @param string $username
     * @return array
     */
    public function byUsername(string $username) : array
    {
        // Set proxy
        $this->setProxy();

        // Scrap user
        $account = collect($this->instagram->getAccount($username));
        sleep(self::SLEEP_REQUEST);

        // Format account
        $data = Format::parseArrayASCIIKey($account);

        // Remove no needed data
        unset($data['medias']);
        unset($data['data']);

        return $data->toArray();
    }

    /**
     * Scrap media by link
     *
     * @param string $link
     * @return array
     */
    public function byMedia(string $link) : array
    {
        // Set proxy
        $this->setProxy();

        // Scrap media
        $media = collect($this->instagram->getMediaByUrl($link));
        sleep(self::SLEEP_REQUEST);

        // Format account
        $data = Format::parseArrayASCIIKey($media);

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
    public function getMedias(Influencer $influencer, $maxID = null, array &$data = [], int $max = self::MAX_REQUEST) : array
    {
        // Set proxy
        $this->setProxy();

        try{
            // Scrap medias
            $instaMedias = $this->instagram->getPaginateMediasByUserId($influencer->account_id, $max, !is_null($maxID) ? $maxID : '');
            sleep(self::SLEEP_REQUEST);
            
            foreach($instaMedias['medias'] as $media){
                // Scrap media
                $_media = $this->getMedia($media->getShortCode(), null, $media);

                // Set media influencer ID
                $_media['influencer_id'] = $influencer->id;

                // Store or update media
                $existsMedia = $this->postRepo->exists($influencer, $_media['post_id']);
                if(!is_null($existsMedia)){
                    // $this->console->writeln("<fg=green>Update post: {$existsMedia->uuid}</>");
                    // $this->console->writeln("<href={$existsMedia->link}>{$existsMedia->link}</>");
                    $this->postRepo->update($existsMedia, $_media);
                    Log::info("Update post: {$existsMedia->short_code}");
                    continue;
                }else{
                    // $this->console->writeln("<fg=green>Create post: {$_media['short_code']}</>");
                    // $this->console->writeln("<href={$_media['link']}>{$_media['link']}</>");
                    $this->postRepo->create($_media);
                    Log::info("Create post: {$_media['short_code']}");
                }

                // Format data
                array_push($data, $_media);
            }

            return $instaMedias['hasNextPage'] ? $this->getMedias($influencer, $instaMedias['maxId'], $data, $max) : $data;
        }catch(\Exception $ex){
            Log::error($ex->getMessage());
            // $this->console->writeln("<fg=red>Something going wrong!</>");

            if($ex->getCode() === 429)
                return $data;
        }
    }

    /**
     * Scrap media details
     * 
     * @param string $mediaShortCode
     * @param \InstagramScraper\Model\Media $media
     * @return array
     */
    public function getMedia(string $mediaShortCode, Tracker $tracker = null, \InstagramScraper\Model\Media $media = null) : array
    {
        // Set proxy
        $this->setProxy();
        
        // Scrap media
        if(is_null($media)){
            $media = $this->instagram->getMediaByCode($mediaShortCode);
            sleep(self::SLEEP_REQUEST);
        }

        // Fetch comments sentiments
        $comments = [];
        $this->getSentimentsAndEmojis($media, $comments);

        // calculate all comments sentiment
        if($media->getCommentsCount() > 0){
            $comments['comments_positive'] = round($comments['comments_positive'] / $media->getCommentsCount(), 2);
            $comments['comments_neutral'] = round($comments['comments_neutral'] / $media->getCommentsCount(), 2);
            $comments['comments_negative'] = round($comments['comments_negative'] / $media->getCommentsCount(), 2); 
        }       

        // Count hashtags on media caption
        $this->hashtags = array_merge($this->hashtags, Format::extractHashTags($media->getCaption()));

        // Add media and comments details
        $_media = [
            'post_id'       =>  $media->getId(),
            'link'          =>  $media->getLink(),
            'short_code'    =>  $media->getShortCode(),
            'type'          =>  $media->getType(),
            'likes'         =>  $media->getLikesCount(),
            'thumbnail_url' =>  $media->getImageThumbnailUrl(),
            'comments'      =>  $media->getCommentsCount(),
            'emojis'        =>  $this->getEmojisSum(),
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
            'caption_hashtags'  =>  $this->hashtags,
            'comments_disabled' =>  $media->getCommentsDisabled(),
            'caption_edited'    =>  $media->isCaptionEdited(),
            'files'             =>  $this->getFiles($media)
        ];

        // Set tracker ID
        if(!is_null($tracker))
            $_media['tracker_id'] = $tracker->id;

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
     * Calculate number of emojis used in comments pf a media
     */
    private function getEmojisSum() : int
    {
        if(sizeof($this->emojis) === 0)
            return 0;

        // Get emojis counts
        $emojisCount = 0;
        array_walk($this->emojis, function($value, $key) use (&$emojisCount){
            if(is_int($key))
                $emojisCount += $key;
        });

        return $emojisCount;
    }

    /**
     * Get media sentiments and emojis from comments
     * 
     * @param \InstagramScraper\Model\Media $media
     * @return null|array
     */
    private function getSentimentsAndEmojis(\InstagramScraper\Model\Media $media, array &$data, int $nextComment = null, $max = self::MAX_REQUEST) : ?array
    {
        // init
        $data = ['comments_positive' => 0, 'comments_neutral' => 0, 'comments_negative' => 0, 'comments_emojis' => [], 'comments_hashtags' => []];

        // Ignore media with disabled comments option
        if($media->getCommentsCount() === 0 || $media->getCommentsDisabled())
            return $data;


        // Load comments
        $comments = $this->instagram->getPaginateMediaCommentsById($media->getId(), $max);
        sleep(self::SLEEP_REQUEST);
            
        foreach($comments['comments'] as $comment){
            // Analyze sentiment
            $analyzer = new Analyzer();
            $sentiment = $analyzer->getSentiment($comment->getText());
            $data['comments_positive'] += $sentiment['pos'];
            $data['comments_neutral'] += $sentiment['neu'];
            $data['comments_negative'] += $sentiment['neg'];

            // Match all emojis
            $data['comments_emojis'] = array_merge($data['comments_emojis'], $this->getCommentEmojis($comment->getText()));

            // Extract comment hashtags
            $data['comments_hashtags'] = array_merge($data['comments_hashtags'], Format::extractHashTags($comment->getText()));
        }

        // Get more comments
        if(isset($comments['haseNextPage']) && !is_null($comments['maxId']))
            return $this->getSentimentsAndEmojis($media, $data, $comments['maxId'], $max);


        // Get top 3 emojis
        // if(isset($data['comments_emojis']) && !empty($data['comments_emojis']))
        //     $data['comments_emojis'] = $this->getTopEmojis($data['comments_emojis']);

        return [
            'comments_positive'  => $data['comments_positive'],
            'comments_neutral'   => $data['comments_neutral'],
            'comments_negative'  => $data['comments_negative'],
            'comments_emojis'    => $data['comments_emojis'],
            'comments_hashtags'  => $data['comments_hashtags']
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
            if(is_null($item) || empty($item) || $item === '#' || $item === '')
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
        $this->emojis = array_flip(array_count_values($emojis));

        // Slice top emojis
        // return array_slice($this->emojis, 0, $max, true);
        // return $this->emojis;
        return array_flip(array_count_values($emojis));
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