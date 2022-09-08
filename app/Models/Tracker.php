<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Tracker extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * Get user
     *
     * @return \App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get campaign
     *
     * @return \App\Campaign
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
    
    /**
     * Get tracker analytics
     *
     * @return \App\TrackerAnalytics
     */
    public function analytics()
    {
        return $this->hasOne(TrackerAnalytics::class)->latest();
    }

    /**
     * Get tracker posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->belongsToMany(InfluencerPost::class, 'tracker_influencer_media');
    }

    /**
     * Get shortlink
     *
     * @return \App\ShortLink
     */
    public function shortlink()
    {
        return $this->hasOne(ShortLink::class, 'tracker_id', 'id');
    }

    /**
     * Get influencers related to trackers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function influencers()
    {
        return $this->belongsToMany(Influencer::class, 'tracker_influencers');
    }
}
