<?php

namespace App\Providers;

use App\Helpers\EmojiParser;
use App\Helpers\FormatHelper;
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
        $this->app->singleton(InstagramScraper::class, function($app){
            return new InstagramScraper($app->make('App\Helpers\EmojiParser'));
        });
        
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
