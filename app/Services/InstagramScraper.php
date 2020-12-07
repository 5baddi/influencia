<?php

namespace App\Services;

use Format;
use Exception;
use Carbon\Carbon;
use App\Influencer;
use App\ScrapAccount;
use GuzzleHttp\Client;
use App\InfluencerPost;
use Sentiment\Analyzer;
use App\Helpers\EmojiParser;
use App\InfluencerPostMedia;
use InstagramScraper\Instagram;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Phpfastcache\Helper\Psr16Adapter;
use Illuminate\Support\Facades\Storage;

class InstagramScraper
{
    /**
     * Max media by each fetch
     */
    const MAX_MEDIA = 100;
    
    /**
     * Max comments by each fetch
     */
    const MAX_COMMENTS = 500;

    /**
     * Sleep request seconds
     */
    const SLEEP_REQUEST = ['min' => 300, 'max' => 1200];

    /**
     * Console Debugging
     * 
     * @var bool
     */
    private static $debug = true;
    
    /**
     * HTTP Request
     * 
     * @var bool
     */
    private static $isHTTPRequest = false;

    /**
     * Instagram scraper
     *
     * @var \InstagramScraper\Instagram
     */
    private $instagram;

    /**
     * Cache manager
     *
     * @var \Phpfastcache\Helper\Psr16Adapter
     */
    private static $cacheManager;

    /**
     * Guzzle HTTP client
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Connected scrap account username
     *
     * @var string
     */
    private $username;

    /**
     * Emoji parser
     *
     * @var \App\Helpers\EmojiParser
     */
    private $emojiParser;

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

    public function __construct(EmojiParser $emojiParser)
    {
        // Init Cache manager
        if(is_null(self::$cacheManager))
            self::$cacheManager = new Psr16Adapter('Files');

        // Init emoji parser
        $this->emojiParser = $emojiParser;

        // Set CURL options
        Instagram::curlOpts([
            CURLOPT_SSL_VERIFYPEER  =>  0,
            CURLOPT_SSL_VERIFYHOST  =>  0,
        ]);

        // TODO: get user stories > https://github.com/postaddictme/instagram-php-scraper/issues/786
    }

    /**
     * Disable console debugging
     * 
     * @return void
     */
    public static function disableDebugging() : void
    {
        self::$debug = false;
    }
    
    /**
     * Use short sleep time on HTTP request
     * 
     * @return void
     */
    public static function isHTTPRequest() : void
    {
        self::$isHTTPRequest = true;
    }

    /**
     * Instagram authentication
     *
     * @param bool $force
     * @return void
     */
    public function authenticate(bool $force = false) : void
    {
        if(!is_null($this->username) && !$force)
            return;
            
        // Get scraping account
        $scrapAccount = ScrapAccount::where(['platform' => 'instagram', 'enabled' => true]);
        
        if(!is_null($this->username) && $scrapAccount->count() > 1)
            $scrapAccount = $scrapAccount->where('username', '!=', $this->username);

        $scrapAccount = $scrapAccount->inRandomOrder()->first();
        if(is_null($scrapAccount))
            throw new \Exception("There's no scraping account!", 111);

        // Set proxy
        if(is_null($this->client))
            $this->setProxy();

        // Init IMAP for Two steps verification
        $emailVecification = new EmailVerification($scrapAccount->imap_email, $scrapAccount->imap_server, $scrapAccount->imap_password);

        // Clear Psr16 cache
        if($force)
            self::$cacheManager->clear();

        // Login to App Instagram account
        $this->instagram = Instagram::withCredentials($scrapAccount->username, $scrapAccount->password, self::$cacheManager);
        $this->instagram->login($force, $emailVecification);
        $this->instagram->saveSession();

        // Save connected scraping account username
        $this->username = $scrapAccount->username;

        $this->log("Successfully connected using account @" . $scrapAccount->username);
    }

    public function setProxy()
    {
        try{
            // Init $client
            $this->client = new Client([
                'base_uri'          =>  url('/'),
                'verify'            =>  !config('app.debug'),
                'debug'             =>  self::$debug,
                'http_errors'       =>  false,
                'proxy'             =>  [
                    config('scraper.proxy.protocol')    =>  config('scraper.proxy.ip') . ':' . config('scraper.proxy.port'),
                ],
                'config'            =>  [
                    'curl'          =>  [
			            CURLOPT_PROXY		    =>  config('scraper.proxy.ip') . ':' . config('scraper.proxy.port'),
                        CURLOPT_SSL_VERIFYPEER  =>  0,
                        CURLOPT_SSL_VERIFYHOST  =>  0,
                        // CURLOPT_SSLVERSION      =>  CURL_SSLVERSION_TLSv1,
                        // CURLOPT_SSL_CIPHER_LIST =>  'TLSv1',
                        CURLOPT_FOLLOWLOCATION  =>  true,
                        CURLOPT_MAXREDIRS       =>  5,
                        CURLOPT_HTTPPROXYTUNNEL =>  1,
                        CURLOPT_RETURNTRANSFER  =>  true,
                        CURLOPT_HEADER          =>  1,
			            CURLOPT_TIMEOUT		    =>  0,
                        CURLOPT_CONNECTTIMEOUT	=>  35,
                        CURLOPT_IPRESOLVE       =>  CURL_IPRESOLVE_V4
                    ]
                ],
                'headers'           =>  [
                    'user-agent'    =>  'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36'
                ]
            ]);

            // Test proxy connection
            $response = $this->client->request('GET', '/api/status');
            if($response->getStatusCode() !== 200)
                throw new \Exception("Something going wrong using the proxy!");

            // Set proxy to the Instagram scraper
            Instagram::curlOpts([
                CURLOPT_SSL_VERIFYPEER  =>  0,
                CURLOPT_SSL_VERIFYHOST  =>  0,
                CURLOPT_FOLLOWLOCATION  =>  true,
                CURLOPT_MAXREDIRS       =>  5,
                CURLOPT_HTTPPROXYTUNNEL =>  1,
                CURLOPT_RETURNTRANSFER  =>  true,
            ]);
            Instagram::setProxy([
                'address' => config('scraper.proxy.ip'),
                'port'    => config('scraper.proxy.port'),
                'tunnel'  => true,
                'timeout' => 35,
            ]);
 
            $this->log("Connected using proxy " . config('scraper.proxy.ip'));
        }catch(\Exception $ex){
            $this->log("Failed to connect using a proxy!", $ex);

            // Unset proxy
            Instagram::disableProxy();

            throw new \Exception("Failed to connect using a proxy!");
        }
    }

    /**
     * Scrap user details by username
     *
     * @param string $username
     * @return array
     */
    public function byUsername(string $username) : array
    {
        try{
            // Authenticate
            $this->authenticate();

            // Scrap user
            $account = $this->instagram->getAccount($username);
            $this->log("User @{$account->getUsername()} details scraped successfully.");
            sleep(rand(self::$isHTTPRequest ? 60 : self::SLEEP_REQUEST['min'], self::$isHTTPRequest ? 120 : self::SLEEP_REQUEST['max']));

            return [
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
        }catch(\Exception $ex){
            $this->log("Can't find influencer by username @{$username}", $ex);

            // Use proxy
            if($this->isTooManyRequests($ex))
                return $this->byUsername($username);

            throw $ex;
        }
    }
    
    /**
     * Scrap user details by ID
     *
     * @param int $id
     * @return array
     */
    public function byId(int $id) : array
    {
        try{
            // Authenticate
            $this->authenticate();

            // Scrap user
            $account = $this->instagram->getAccountById($id);
            $this->log("User @{$account->getUsername()} details scraped successfully.");
            sleep(rand(self::$isHTTPRequest ? 60 : self::SLEEP_REQUEST['min'], self::$isHTTPRequest ? 120 : self::SLEEP_REQUEST['max']));

            return [
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
        }catch(\Exception $ex){
            $this->log("Can't find influencer by ID {$id}", $ex);

            // Use proxy
            if($this->isTooManyRequests($ex))
                return $this->byId($id);

            throw $ex;
        }
    }

    /**
     * Scrap media by short code
     *
     * @param string $shortCode
     * @return \InstagramScraper\Model\Media
     */
    public function byMedia(string $shortCode) : \InstagramScraper\Model\Media
    {
        try{
            // Authenticate
            $this->authenticate();

            // Scrap media
            $media = $this->instagram->getMediaByCode($shortCode);
            $this->log("Media {$media->getShortCode()} details scraped successfully.");
            sleep(rand(self::$isHTTPRequest ? 60 : self::SLEEP_REQUEST['min'], self::$isHTTPRequest ? 120 : self::SLEEP_REQUEST['max']));

            return $media;
        }catch(\Exception $ex){
            $this->log("Can't get media by short code {$shortCode}", $ex);

            // Use proxy
            if($this->isTooManyRequests($ex))
                return $this->byMedia($shortCode);

            throw $ex;
        }
    }

    /**
     * Analyze media and get sentiments and emojis
     *
     * @param Array $media
     * @return array
     */
    public function analyzeMedia(array $media) : array
    {
        return $this->getSentimentsAndEmojis($media);
    }

    /**
     * Scrap user medias
     *
     * @param Influencer $influencer
     * @param string $nextCursor
     * @param int $maxID
     * @return void
     */
    public function getMedias(Influencer $influencer, string $nextCursor = null, int $max = self::MAX_MEDIA)
    {
        try{
            $this->log("Scrap media for influencer @{$influencer->username}");

            // Authenticate with scraping account
            $this->authenticate();

            // Start from last inserted media
            $lastPost = InfluencerPost::where('influencer_id', $influencer->id)->whereNotNull('next_cursor')->latest();
            if(!is_null($nextCursor) && $nextCursor !== '')
                $lastPost = InfluencerPost::where(['influencer_id' => $influencer->id,'next_cursor' => $nextCursor]);
                
            $lastPost = $lastPost->first();
            $maxID = !is_null($lastPost) ? $lastPost->next_cursor : '';
            $this->log("Start scraping from " . $maxID);
            
            // Scrap medias
            $fetchedMedias = $this->instagram->getPaginateMediasByUserId($influencer->account_id, $max, $maxID ?? null);
            $this->log("Start scraping next " . sizeof($fetchedMedias['medias']) . " posts...");
            sleep(rand(self::SLEEP_REQUEST['min'], self::SLEEP_REQUEST['max']));

            foreach($fetchedMedias['medias'] as $key => $media){
                $this->log("Handle media {$media->getShortCode()}");

                // Check media if already exists
                $existsMedia = InfluencerPost::where('post_id', $media->getId())->first();
                if(!is_null($existsMedia))
                    continue;

                // Scrap media
                $_media = $this->getMedia($media);

                // Set media influencer ID
                $_media['influencer_id'] = $influencer->id;

                // Set end cursor
                if($key === array_key_last($fetchedMedias['medias']) && $fetchedMedias['hasNextPage'] && isset($fetchedMedias['maxId']) && $fetchedMedias['maxId'] !== '')
                    $_media['next_cursor'] = $fetchedMedias['maxId'];

                // Store media
                $post = InfluencerPost::create($_media);

                // Store media assets 
                array_walk($_media['files'], function($file) use ($post){
                    if(empty($file) || is_null($file) || !is_array($file))
                        return;
        
                    // Push added media record
                    $file = array_merge($file, ['post_id' =>  $post->id]);
                    InfluencerPostMedia::updateOrCreate(['post_id' => $file['post_id'], 'file_id' => $file['file_id']], $file);
                });

                $this->log("New post: {$_media['short_code']} | {$_media['link']}");

                // Unset scraped media
                unset($fetchedMedias['medias'][$key]);
            }

            // Scraping more
            if($fetchedMedias['hasNextPage'])
                return $this->getMedias($influencer, $fetchedMedias['maxId'], $max);
        }catch(\Exception $ex){
            $this->log("Can't get media for influencer @{$influencer->username}", $ex);

            // Use proxy
            if($this->isTooManyRequests($ex))
                return $this->getMedias($influencer, (isset($fetchedMedias) && $fetchedMedias['hasNextPage']) ? $fetchedMedias['maxId'] : null, $max);

            throw $ex;
        }
    }

    /**
     * Scrap media details
     *
     * @param \InstagramScraper\Model\Media $media
     * @return array
     */
    public function getMedia(\InstagramScraper\Model\Media $media) : array
    {
        try{
            // Count hashtags on media caption
            $this->hashtags = array_merge($this->hashtags, Format::extractHashTags($media->getCaption()));

            // Add media and comments details
            $_media = [
                'post_id'       =>  $media->getId(),
                'next_cursor'   =>  null,
                'link'          =>  $media->getLink(),
                'short_code'    =>  $media->getShortCode(),
                'type'          =>  $media->getType(),
                'likes'         =>  $media->getLikesCount(),
                'thumbnail_url' =>  $media->getImageThumbnailUrl(),
                'comments'      =>  $media->getCommentsCount() ?? 0,
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
                // 'comments_disabled' =>  $media->getCommentsDisabled(),
                'caption_edited'    =>  $media->isCaptionEdited(),
                'files'             =>  $this->getFiles($media)
            ];

            return $_media;
        }catch(\Exception $ex){
            $this->log("Can't get media details {$media->getShortCode()}", $ex);

            throw $ex;
        }
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

        $this->log("Media {$media->getShortCode()} files: " . sizeof($files));

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

        $this->log("Media {$media->getShortCode()} File: {$url}");

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
        try{
            if($media->getType() === 'video'){
                Storage::disk('local')->put('/tmp/' . $media->getShortCode(), file_get_contents($media->getVideoStandardResolutionUrl() ?? $media->getVideoStandardResolutionUrl()));
                $video = new GetId3(new UploadedFile(Storage::disk('local')->path('/tmp/' . $media->getShortCode()), $media->getShortCode()));
                $duration = $video->getPlaytimeSeconds();
                Storage::disk('local')->delete('/tmp/' . $media->getShortCode());

                $this->log("Video duration for media {$media->getShortCode()} is {$video->getPlaytimeSeconds()}s");
    
                return $duration;
            }
        }catch(\Exception $ex){
            $this->log("Get video details for media {$media->getShortCode()}", $ex);
        }

        return null;
    }

    /**
     * Get media sentiments and emojis from comments
     *
     * @param array $media
     * @return array
     */
    private function getSentimentsAndEmojis(array $media, array &$data = [], string $nextComment = null, $max = self::MAX_COMMENTS) : ?array
    {
        try{
            // init
            $data = ['comments_positive' => 0, 'comments_neutral' => 0, 'comments_negative' => 0, 'comments_emojis' => [], 'comments_hashtags' => []];

            // Ignore media without comments
            if($media['comments'] === 0)
                return $data;


            // Load comments
            $comments = $this->instagram->getMediaCommentsById($media['post_id'], $media['comments'] < $max ? $media['comments'] : $max, $nextComment);
            $this->log("Media {$media['short_code']} comments: " . sizeof($comments));
            // sleep(rand(self::SLEEP_REQUEST['min'], self::SLEEP_REQUEST['max']));

            if(sizeof($comments) === 0)
                return $data;

            // Handle method
            $handle = function($comment) use(&$data){
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
            };
            
            // Parse ana analyze comments
            foreach($comments as $comment){
                // Handle comment
                $handle($comment);

                // Handle child comments
                if($comment->getChildCommentsCount() > 0){
                    foreach($comment->getChildComments() as $child)
                        $handle($child);
                }

                // Load more comments
                if($comment->hasMoreChildComments())
                    $this->getSentimentsAndEmojis($media, $data, $comment->getChildCommentsNextPage(), $max);
            }

            $this->log("Sentiments for media {$media['short_code']} is Positive {$data['comments_positive']} | Neutral {$data['comments_neutral']} | Negative {$data['comments_negative']}");

            return [
                'comments_positive'  => round($data['comments_positive'] ?? 0 / $media['comments'], 2),
                'comments_neutral'   => round($data['comments_neutral'] ?? 0 / $media['comments'], 2),
                'comments_negative'  => round($data['comments_negative'] ?? 0 / $media['comments'], 2),
                'comments_emojis'    => $data['comments_emojis'],
                'emojis'             => sizeof($data['comments_emojis']),
                'comments_hashtags'  => $data['comments_hashtags']
            ];
        }catch(\Exception $ex){
            $this->log("Can't get comments for media {$media['short_code']}", $ex);

            // Use proxy
            if($this->isTooManyRequests($ex))
                return $this->getSentimentsAndEmojis($media, $data, $nextComment, $max);

            throw $ex;
        }
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
        $_emojis = $this->emojiParser->matchAll($comment);

        // Ignore empty emojis list
        if(empty($_emojis))
            return [];

        // Slice empty emoji
        $emojis = [];
        array_walk($_emojis, function($item, $key) use (&$emojis){
            if(!is_null($item) && !empty($item) && $item !== '#' && $item !== '')
                array_push($emojis, $item);
        });

        $this->log('Parsed Emojis: ' . sizeof($emojis));

        return $emojis;
    }

    /**
     * Verify exception is too many requests exception
     *
     * @param \Exception $ex
     * @return boolevoidan
     */
    private function isTooManyRequests(\Exception $ex) : bool
    {
        $this->log("It would be too many requests issue!", $ex);

        // Should try after a while
        if($ex->getCode() === 403 || $ex->getCode() === 560){
            $this->authenticate(true);

            return true;
        }

        // Is too many requests or lost connection
        if(get_class($ex) === \Unirest\Exception::class
                || $ex->getCode() === 429 || $ex->getCode() === 56 || $ex->getCode() === 302
                || strpos($ex->getMessage(), "OpenSSL SSL_connect") !== false
                || strpos($ex->getMessage(), "Response code is 302") !== false
                || strpos($ex->getMessage(), "unable to connect to") !== false
                || strpos($ex->getMessage(), "Proxy CONNECT aborted") !== false
                || strpos($ex->getMessage(), "proxy after CONNECT") !== false
                || strpos($ex->getMessage(), "Failed receiving connect request ack: Failure when receiving data from the peer") !== false){

            // Set proxy
            $this->setProxy();

            // Maybe IP blocked and need re-authenticate
            if($ex->getCode() === 302)
                $this->authenticate(true);

            return true;
        }

        return false;
    }

    /**
     * Trace log
     *
     * @param string $message
     * @param \Exception|null $exception
     * @return void
     */
    private function log(string $message, \Exception $exception = null)
    {
        if(is_null($exception)){
            if(self::$debug)
                Log::channel('stderr')->info($message);

            Log::info($message);
        }else{
            if(self::$debug)
                Log::channel('stderr')->error($message);

            Log::error($exception->getMessage(), [
                'context'   =>  "Instagram Scraper with Code: {$exception->getCode()} Line: {$exception->getLine()}"
            ]);
        }
    }
}
