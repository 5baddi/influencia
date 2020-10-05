<?php

namespace App\Providers;

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
        $this->app->singleton(InstagramScraper::class, function(){
            return new InstagramScraper();
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
