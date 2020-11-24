<?php

namespace App\Services;

use Format;
use Exception;
use App\Tracker;
use Carbon\Carbon;
use App\Influencer;
use GuzzleHttp\Client;
use App\InfluencerPost;
use Sentiment\Analyzer;
use App\Helpers\EmojiParser;
use InstagramScraper\Instagram;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Phpfastcache\Helper\Psr16Adapter;
use Illuminate\Support\Facades\Storage;
use App\Repositories\InfluencerPostRepository;
use App\Console\Commands\ScrapInstagramInfluencers;
use Symfony\Component\Console\Output\ConsoleOutput;

class InstagramScraper
{
    /**
     * Max request by each fetch
     */
    const MAX_REQUEST = 25;

    /**
     * Sleep request seconds
     */
    const SLEEP_REQUEST = 10;

    /**
     * Instagram scraper
     *
     * @var \InstagramScraper\Instagram
     */
    private $instagram;

    /**
     * HTTP Client
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Cache manager
     *
     * @var \Phpfastcache\Helper\Psr16Adapter
     */
    private $cacheManager;

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
        // Init Cache manager
        $this->cacheManager = new Psr16Adapter('Files');

        // Init emoji parser
        $this->emojiParser = $emojiParser;

        // Init repositories
        $this->postRepo = $postRepo;

        // Init console
        $this->console = new ConsoleOutput();

        // Init HTTP Client
        $this->client = new Client([
            'verify'    =>  !config('app.debug')
        ]);

        // TODO: get user stories > https://github.com/postaddictme/instagram-php-scraper/issues/786

        // Init instagram scraper
        try{
            $this->instagramAuthentication();
        }catch(\Exception $ex){
            $this->console->writeln("<fg=red>{$ex->getMessage()}</>");
            // Trace log
            Log::error($ex->getMessage());
        }
    }

    /**
     * Instagram authentication
     *
     * @return void
     */
    public function instagramAuthentication(bool $force = false) : void
    {
        try{
            // Init IMAP for Two steps verification
            $emailVecification = new EmailVerification(env("IMAP_EMAIL"), env("IMAP_SERVER"), env("IMAP_PASSWORD"));

            // Login to App Instagram account
            $this->instagram = Instagram::withCredentials($this->client, env("INSTAGRAM_ACCOUNT"), env("INSTAGRAM_PASSWORD"), $this->cacheManager);
            $this->instagram->login($force, $emailVecification);
            $this->instagram->saveSession();
        }catch(Exception $ex){
            $this->console->writeln("<fg=red>{$ex->getMessage()}</>");
            // Trace log
            Log::error($ex->getMessage());

            $this->instagram = new Instagram($this->client);
        }
    }

    public function setProxy()
    {
        try{
            // Init $client
            $this->client = new Client([
                'verify'            =>  !config('app.debug'),
                'proxy'             =>  env('MAIN_PROXY_PROTOCOL') . '://' . env('MAIN_PROXY_IP') . ':' . env('MAIN_PROXY_PORT'),
                'timeout'           =>  300,
                'connect_timeout'   =>  35,
                'config'            =>  [
                    'curl'          =>  [
                        CURLOPT_SSL_VERIFYPEER  =>  0,
                        CURLOPT_SSL_VERIFYHOST  =>  0,
                        CURLOPT_FOLLOWLOCATION  =>  1,
                        CURLOPT_MAXREDIRS       =>  5,
                        CURLOPT_HTTPPROXYTUNNEL =>  1,
                        CURLOPT_RETURNTRANSFER  =>  1,
                        CURLOPT_HEADER          =>  1
                    ]
                ]
            ]);

            $this->console->writeln("<fg=yellow>Connect using proxy: " . env('MAIN_PROXY_IP') . ":" . env('MAIN_PROXY_PORT') . "</>");
        }catch(\Exception $ex){
            $this->console->writeln("<fg=red>{$ex->getMessage()}</>");
            Log::error($ex->getMessage());
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
            // Scrap user
            $account = $this->instagram->getAccount($username);
            sleep(self::SLEEP_REQUEST);

            return [
                'account_id'    =>  $account->getId(),
                'username'      =>  $account->getUsername(),
                'name'          =>  $account->getFullName(),
                'pic_url'       =>  $account->getProfilePicUrl(),
                'biography'     =>  $account->getBiography(),
                'website'       =>  $account->getExternalUrl(),
                'followers'     =>  $account->getFollowedByCount(),
                'follows'       =>  $account->getFollowsCount(),
                'posts'         =>  $account->getMediaCount(),
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
            $this->console->writeln("<fg=red>{$ex->getMessage()}</>");
            Log::error($ex->getMessage());

            // Use proxy
            if($this->isTooManyRequests($ex)){
                $this->console->writeln("<fg=red>429 Too Many Requests!</>");
                $this->setProxy();
                $this->instagramAuthentication(true);

                return $this->byUsername($username);
            }

            if(strpos($ex->getMessage(), "OpenSSL SSL_connect") !== false)
                throw new \Exception("Lost connection to Instagram");

            $this->console->writeln("<fg=red>{$ex->getMessage()}</>");
            throw $ex;
        }
    }

    /**
     * Scrap media by link
     *
     * @param string $link
     * @return \InstagramScraper\Model\Media
     */
    public function byMedia(string $link) : \InstagramScraper\Model\Media
    {
        try{
            // Scrap media
            $media = $this->instagram->getMediaByUrl($link);
            sleep(self::SLEEP_REQUEST);

            return $media;
        }catch(\Exception $ex){
            Log::error($ex->getMessage());
            $this->console->writeln("<fg=red>{$ex->getMessage()}</>");

            // Use proxy
            if($this->isTooManyRequests($ex)){
                $this->console->writeln("<fg=red>429 Too Many Requests!</>");
                $this->setProxy();
                $this->instagramAuthentication(true);

                return $this->byMedia($link);
            }

            if(strpos($ex->getMessage(), "OpenSSL SSL_connect") !== false)
                throw new \Exception("Lost connection to Instagram");

            throw $ex;
        }
    }

    /**
     * Scrap user medias
     *
     * @param Influencer $influencer
     * @param bool $force Force update all medias
     * @param string $nextCursor
     * @param int $maxID
     * @return void
     */
    public function getMedias(Influencer $influencer, bool $force = false, string $nextCursor = null, int $max = self::MAX_REQUEST)
    {
        try{
            if(!$force){
                $lastPost = $influencer->posts()->where('influencer_id', $influencer->id)->whereNotNull('next_cursor')->latest()->first();
                $maxID = !is_null($lastPost) ? $lastPost->next_cursor : '';
                $this->console->writeln("<fg=green>Start scraping from " . $lastPost->short_code . "</>");
            }

            // Scrap medias
            $fetchedMedias = $this->instagram->getPaginateMediasByUserId($influencer->account_id, $max, $maxID ?? null);
            $this->console->writeln("<fg=green>Start scraping next " . sizeof($fetchedMedias['medias']) . " posts...</>");

            sleep(self::SLEEP_REQUEST);

            foreach($fetchedMedias['medias'] as $key => $media){
                // Scrap media
                $_media = $this->getMedia($media->getShortCode(), $media);

                // Set media influencer ID
                $_media['influencer_id'] = $influencer->id;

                // Set end cursor
                if($key === array_key_last($fetchedMedias['medias']) && $fetchedMedias['hasNextPage'])
                    $_media['next_cursor'] = $fetchedMedias['maxId'];
                // Force scrap next_cursor
                if($key === array_key_last($fetchedMedias['medias']) && $fetchedMedias['hasNextPage'] && $force)
                    $nextCursor = $fetchedMedias['maxId'];

                // Store or update media
                $existsMedia = $this->postRepo->exists($influencer, $_media['post_id']);
                if(!is_null($existsMedia)){
                    $this->console->writeln("<fg=green>Update post: {$existsMedia->uuid}</>");
                    $this->console->writeln("<href={$existsMedia->link}>{$existsMedia->link}</>");
                    $this->postRepo->update($existsMedia, $_media);
                    Log::info("Update post: {$existsMedia->short_code}");
                    continue;
                }else{
                    $this->console->writeln("<fg=green>Create post: {$_media['short_code']}</>");
                    $this->console->writeln("<href={$_media['link']}>{$_media['link']}</>");
                    $this->postRepo->create($_media);
                    Log::info("Create post: {$_media['short_code']}");
                }

                // Unset scraped media
                unset($fetchedMedias['medias'][$key]);
            }

            // Verify the max requests calls
            if(ScrapInstagramInfluencers::checkPassedMaxCalls()){
                $this->error("We will continue scraping after one hour because bypass the max requests per hour!");
                return;
            }

            // Scraping more
            if($fetchedMedias['hasNextPage'])
                return $this->getMedias($influencer, $force, $nextCursor ?? null, $max);
        }catch(\Exception $ex){
            Log::error($ex->getMessage());
            $this->console->writeln("<fg=red>{$ex->getMessage()}</>");

            // Use proxy
            if($this->isTooManyRequests($ex)){
                $this->console->writeln("<fg=red>429 Too Many Requests!</>");
                $this->setProxy();
                $this->instagramAuthentication(true);

                return $this->getMedias($influencer, $force, $nextCursor ?? null, $max);
            }

            if(strpos($ex->getMessage(), "OpenSSL SSL_connect") !== false)
                throw new \Exception("Lost connection to Instagram");

            throw $ex;
        }
    }

    /**
     * Scrap media details
     *
     * @param string $mediaShortCode
     * @param \InstagramScraper\Model\Media $media
     * @param \App\Tracker $tracker
     * @return array
     */
    public function getMedia(string $mediaShortCode, \InstagramScraper\Model\Media $media = null, Tracker $tracker = null) : array
    {
        try{
            // Scrap media
            if(is_null($media)){
                $media = $this->instagram->getMediaByCode($mediaShortCode);
                sleep(self::SLEEP_REQUEST);
            }
        }catch(\Exception $ex){
            // Use proxy
            if($this->isTooManyRequests($ex)){
                $this->console->writeln("<fg=red>429 Too Many Requests!</>");
                $this->setProxy();
                $this->instagramAuthentication(true);

                return $this->getMedia($mediaShortCode, $media, $tracker);
            }

            if(strpos($ex->getMessage(), "OpenSSL SSL_connect") !== false)
                throw new \Exception("Lost connection to Instagram");

            $this->console->writeln("<fg=red>{$ex->getMessage()}</>");
            Log::error($ex->getMessage());
            throw $ex;
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
            'next_cursor'   =>  null,
            'link'          =>  $media->getLink(),
            'short_code'    =>  $media->getShortCode(),
            'type'          =>  $media->getType(),
            'likes'         =>  $media->getLikesCount(),
            'thumbnail_url' =>  $media->getImageThumbnailUrl(),
            'comments'      =>  $media->getCommentsCount(),
            'emojis'        =>  sizeof($comments['comments_emojis']),
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
     * Get media sentiments and emojis from comments
     *
     * @param \InstagramScraper\Model\Media $media
     * @return null|array
     */
    private function getSentimentsAndEmojis(\InstagramScraper\Model\Media $media, array &$data, string $nextComment = null, $max = self::MAX_REQUEST) : ?array
    {
        // init
        $data = ['comments_positive' => 0, 'comments_neutral' => 0, 'comments_negative' => 0, 'comments_emojis' => [], 'comments_hashtags' => []];

        // Ignore media with disabled comments option
        if($media->getCommentsCount() === 0 || $media->getCommentsDisabled())
            return $data;


        // Load comments
        try{
            $comments = $this->instagram->getMediaCommentsById($media->getId(), $max, $nextComment);
            sleep(self::SLEEP_REQUEST);
        }catch(\Exception $ex){
            Log::error($ex->getMessage());
            $this->console->writeln("<fg=red>{$ex->getMessage()}</>");

            // Use proxy
            if($this->isTooManyRequests($ex)){
                $this->console->writeln("<fg=red>429 Too Many Requests!</>");
                $this->setProxy();
                $this->instagramAuthentication(true);

                return  $this->getSentimentsAndEmojis($media, $data, $nextComment, $max);
            }

            if(strpos($ex->getMessage(), "OpenSSL SSL_connect") !== false)
                throw new \Exception("Lost connection to Instagram");

            throw $ex;
        }

        foreach($comments as $comment){
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

            // Handle comment
            $handle($comment);

            // unset($fetchedComments['comments'][$key]);

            // Handle child comments
            if(sizeof($comment->getChildComments()) > 0){
                foreach($comment->getChildComments() as $child)
                    $handle($child);
            }

            // Load more comments
            if($comment->hasMoreChildComments())
                $this->getSentimentsAndEmojis($media, $data, $comment->getChildCommentsNextPage(), $max);
        }

        // Get more comments
        // if(isset($fetchedComments['haseNextPage']) && !is_null($fetchedComments['maxId']))
            // return $this->getSentimentsAndEmojis($media, $data, $fetchedComments, $fetchedComments['maxId'], $max);


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
     * Verify exception is too many requests exception
     *
     * @param \Exception $ex
     * @return boolean
     */
    private function isTooManyRequests(\Exception $ex)
    {
        return get_class($ex) === \Unirest\Exception::class
                || $ex->getCode() === 429
                || strpos($ex->getMessage(), "Response code is 302") !== false
                || strpos($ex->getMessage(), "unable to connect to") !== false
                || strpos($ex->getMessage(), "Received HTTP code 400 from proxy after CONNECT") !== false
                || strpos($ex->getMessage(), "Failed receiving connect request ack: Failure when receiving data from the peer") !== false;
    }
}
