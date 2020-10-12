<?php

namespace App\Providers;

use App\Helpers\EmojiParser;
use App\Services\InstagramScraper;
use Illuminate\Support\ServiceProvider;

class ScraperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register Instagram scraper
        $this->app->singleton(InstagramScraper::class, function($app){
            return new InstagramScraper($app->make('App\Helpers\EmojiParser'), $app->make('App\Repositories\InfluencerPostRepository'));
        });
        
        // Register Emojis parser
        $this->app->singleton(EmojiParser::class, function(){
            return new EmojiParser();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
