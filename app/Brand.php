<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Brand extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['trackers_count'];

    /**
     * Get tracker count for the whole brand
     *
     * @return int
     */
    public function getTrackersCountAttribute() : int
    {
        // Init
        $trackersCount = 0;
        
        // Calculate trackers count for each campaign
        $this->campaigns()->each(function($campaign) use(&$trackersCount) {
            $trackersCount += $campaign->trackers()->count();
        });

        return $trackersCount;
    }

    /**
     * Get users
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'brand_user');
    }
    
    /**
     * Get campaigns
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
