<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Tracker extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'campaign_id',
        'platform',
        'name',
        'type',
        'url',
        'nbr_squences',
        'nbr_squences_impressions',
        'nbr_impressions_first_sequence',
        'reach_first_sequence',
        'sticker_taps_mentions',
        'sticker_taps_hashtags',
        'link_clicks',
        'nbr_replies',
        'nbr_taps_forward',
        'nbr_taps_backward',
        'posted_date',
        'posted_hour',
        'status',
        'queued'
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'       =>  'unsignedInteger',
        'campaign_id'   =>  'unsignedInteger',
        'posted_date'   =>  'date',
        'posted_time'   =>  'time',
        'status'        =>  'boolean',
        'updated_at'    =>  'datetime:Y-m-d H:i',
        'created_at'    =>  'datetime:Y-m-d H:i',
    ];

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
     * Get tracker media files
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medias()
    {
        return $this->hasMany(TrackerMedia::class);
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
     * Get count of influencers related to trackers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function influencers()
    {
        return $this->belongsToMany(Influencer::class, 'tracker_influencers');
    }

    /**
     * Get last update datetime as humains readable
     *
     * @return string
     */
    public function getLastUpdateAttribute() : string
    {
        return Carbon::createFromTimeStamp(strtotime($this->attributes['updated_at']))->diffForHumans();
    }
}
