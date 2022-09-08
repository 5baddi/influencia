<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Brand extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'updated_at'  =>  'datetime:Y-m-d H:i',
        'created_at'  =>  'datetime:Y-m-d H:i',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'trackers_count'
    ];

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
     * Get user avatar as base64
     * 
     * @return string|null
     */
    public function getLogoAttribute() : ?string
    {
        if(isset($this->attributes['logo']) && Storage::disk('local')->exists($this->attributes['logo']))
            return "data:image/png;base64," . base64_encode(Storage::disk('local')->get($this->attributes['logo']));

        return null;
    }

    /**
     * Get users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'brand_users');
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

    /**
     * Get influencers related to trackers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function influencers()
    {
        return $this->belongsToMany(Influencer::class, 'brand_influencers')->withCount(['posts', 'trackers']);
    }
}
