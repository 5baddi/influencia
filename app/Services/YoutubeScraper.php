<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Youtube Scraper
 *
 * https://github.com/baddiservices/YoutubeScraperPhp
 * https://tylpk.blogspot.com/2018/03/use-php-to-download-youtube-video.html
 */
class YoutubeScraper
{
    /** Youtube categories list by ID's */
    const CATEGORIES = [
        1   =>  "Film & Animation",
        2   =>  "Autos & Vehicles",
        10  =>  "Music",
        15  =>  "Pets & Animals",
        17  =>  "Sports",
        18  =>  "Short Movies",
        19  =>  "Travel & Events",
        20  =>  "Gaming",
        21  =>  "Videoblogging",
        22  =>  "People & Blogs",
        23  =>  "Comedy",
        24  =>  "Entertainment",
        25  =>  "News & Politics",
        26  =>  "Howto & Style",
        27  =>  "Education",
        28  =>  "Science & Technology",
        29  =>  "Nonprofits & Activism",
        30  =>  "Movies",
        31  =>  "Anime/Animation",
        32  =>  "Action/Adventure",
        33  =>  "Classics",
        34  =>  "Comedy",
        35  =>  "Documentary",
        36  =>  "Drama",
        37  =>  "Family",
        38  =>  "Foreign",
        39  =>  "Horror",
        40  =>  "Sci-Fi/Fantasy",
        41  =>  "Thriller",
        42  =>  "Shorts",
        43  =>  "Shows",
        44  =>  "Trailers"
    ];

    /**
     * Console Debugging
     * 
     * @var bool
     */
    private static $debug = true;

    /**
     * HTTP Client
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Throw exception if no youtube api key
        if(is_null(config('scraper.youtube.key')))
            throw new \Exception("Please provide a valid Youtube API key!");

        // Init HTTP client
        $this->client = new Client([
            'base_uri'          =>  "https://www.googleapis.com/youtube/v3/",
            'verify'            =>  !config('app.debug'),
            'debug'             =>  self::$debug,
            'http_errors'       =>  false,
        ]);
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
     * Extract video ID from URL
     *
     * @param string $videoURL
     * @return string|null
     */
    public function extractVideoID(string $videoURL) : ?string
    {
        // Match video id in the URL
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoURL, $match);

        return $match[1] ?? null;
    }

    /**
     * Get video details by ID
     * 
     * @param string $videoURL
     * @return array
     */
    public function getVideoByID(string $videoURL) : array
    {
        // Parse video ID
        $ID = $this->extractVideoID($videoURL);
        if(is_null($ID))
            throw new \Exception("Failed to parse video ID! Please check the video URL");
            
        try{
            // Send get request to get video details
            $response = $this->client->get("videos?part=snippet&id={$ID}&key=" . config('scraper.youtube.key'));
            $obj = json_decode($response->getBody()->getContents());
            // dd($obj);

            return [
                "short_code"        =>  $obj->items[0]->id,
                "channel_id"        =>  $obj->items[0]->snippet->channelId,
                "title"             =>  $obj->items[0]->snippet->title,
                "type"              =>  "video",
                "link"              =>  "https://www.youtube.com/watch?v={$obj->items[0]->id}",
                "caption"           =>  $obj->items[0]->snippet->description,
                "tags"              =>  $obj->items[0]->snippet->tags,
                "category_id"       =>  $obj->items[0]->snippet->categoryId,
                "category"          =>  $this->getCategoryNameByID($obj->items[0]->snippet->categoryId),
                "language"          =>  $obj->items[0]->snippet->defaultLanguage,
                "audio_language"    =>  $obj->items[0]->snippet->defaultAudioLanguage,
                "is_livebroadcast"  =>  $obj->items[0]->snippet->liveBroadcastContent !== "none",
                "thumbnail_url"     =>  $obj->items[0]->snippet->thumbnails->maxres->url,
                "published_at"      =>  Carbon::parse($obj->items[0]->snippet->publishedAt)->format("Y-m-d H:i:s")
            ];
        }catch(RequestException $reqEx){
            // Trace 
        }
    }

    /**
     * Get video category name by category ID
     *
     * @param integer $categoryID
     * @return string|null
     */
    public function getCategoryNameByID(int $categoryID) : ?string
    {
        return self::CATEGORIES[$categoryID] ?? null;
    }
}
