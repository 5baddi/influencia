<?php

namespace App\Providers;

use App\User;
use App\Brand;
use App\Tracker;
use App\Policies\UserPolicy;
use App\Policies\BrandPolicy;
use App\Policies\TrackerPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        User::class     =>  UserPolicy::class,
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
