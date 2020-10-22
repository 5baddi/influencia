<?php

namespace App\Providers;

use App\Brand;
use App\Policies\BrandPolicy;
use App\Policies\TrackerPolicy;
use App\Tracker;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Tracker::class  =>  TrackerPolicy::class,
        Brand::class    =>  BrandPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
