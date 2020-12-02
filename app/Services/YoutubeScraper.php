<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Youtube Scraper
 *
 * https://github.com/baddiservices/YoutubeScraperPhp
 * https://tylpk.blogspot.com/2018/03/use-php-to-download-youtube-video.html
 */
class YoutubeScraper
{
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
        $this->client = new Client([
            'base_uri'          =>  url('/'),
            'verify'            =>  !config('app.debug'),
            // 'debug'             =>  config('app.debug'),
            'http_errors'       =>  false,
        ]);
    }
}
