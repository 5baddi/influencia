<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Campaign extends Model
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
        'influencers',
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
     * Get brand
     *
     * @return \App\Brand
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get campaign trackers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackers()
    {
        return $this->hasMany(Tracker::class, 'campaign_id')
                ->with('posts')
                ->where([
                    'status'    => true,
                    'queued'    =>  'finished'
                ]);
    }

    /**
     * Get tracker analytics
     *
     * @return \App\CampaignAnalytics
     */
    public function analytics()
    {
        return $this->hasOne(CampaignAnalytics::class)->latest();
    }

    /**
     * Get list of influencers
     * 
     * @return Illuminate\Support\Collection
     */
    public function getInfluencersAttribute() : Collection
    {
        $influencers = new Collection();

        foreach($this->trackers->load('influencers') as $tracker){
            if(is_null($tracker->influencers) || $tracker->influencers->count() === 0)
                continue;

            foreach($tracker->influencers as $influencer){
                if($influencers->contains('uuid', $influencer->uuid))
                    continue;

                $influencers->add($influencer->only(['uuid', 'name', 'username', 'pic_url']));
            }
        }

        return $influencers;
    }
}
