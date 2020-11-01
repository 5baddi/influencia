<?php

namespace App;

use App\Events\TrackerUpdated;
use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Tracker extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'updated' => TrackerUpdated::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

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
        'username',
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
        'queued',
        'influencer_id'
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'       =>  'unsignedInteger',
        'campaign_id'   =>  'unsignedInteger',
        'influencer_id' =>  'unsignedInteger',
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
     * Get influencer
     *
     * @return \App\Influencer
     */
    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
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
        return $this->hasMany(InfluencerPost::class, 'tracker_id', 'id');
    }
}
