<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class InfluencerPost extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'influencer_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'next_cursor',
        'link',
        'short_code',
        'type',
        'likes',
        'thumbnail_url',
        'comments',
        'emojis',
        'published_at',
        'caption',
        'alttext',
        'location',
        'location_id',
        'location_slug',
        'location_json',
        'video_views',
        'video_duration',
        'is_ad',
        'caption_hashtags',
        'comments_disabled',
        'caption_edited',
        'influencer_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'caption_hashtags'       =>  'json',
        'comments_emojis'        =>  'json',
        'comments_hashtags'      =>  'json',
        'location_json'          =>  'json',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hashtags_count', 
        'sequences', 
        'image_sequences',
        'video_sequences',
        'activated_communities', 
        'estimated_impressions', 
        'organic_impressions', 
        'engagements',
        'calculated_engagement_rate',
        'earned_media_value'
    ];

    /**
     * Get Emojis list
     * 
     * @return array
     */
    public function getCommentsEmojisAttribute()
    {
        $result = json_decode($this->attributes['comments_emojis']);
        if(is_array($result) && sizeof($result) > 0)
            krsort($result);

        return $result;
    }
    
    /**
     * Set Emojis list
     * 
     * @return void
     */
    public function setCommentsEmojisAttribute($value)
    {
        if(!is_string($value))
            $this->attributes['comments_emojis'] = json_encode($value);
    }
    
    /**
     * Get Hashtags list
     * 
     * @return array
     */
    public function getCommentsHashtagsAttribute()
    {
        $result = json_decode($this->attributes['comments_hashtags']);

        return $result;
    }
    
    /**
     * Set Hashtags list
     * 
     * @return void
     */
    public function setCommentsHashtagsAttribute($value)
    {
        if(!is_string($value))
            $this->attributes['comments_hashtags'] = json_encode($value);
    }
    
    /**
     * Get Hashtags list
     * 
     * @return array
     */
    public function getCaptionHashtagsAttribute()
    {
        $result = json_decode($this->attributes['caption_hashtags']);

        return $result;
    }
    
    /**
     * Set Hashtags list
     * 
     * @return void
     */
    public function setCaptionHashtagsAttribute($value)
    {
        if(!is_string($value))
            $this->attributes['caption_hashtags'] = json_encode($value);
    }
    
    /**
     * Get location
     * 
     * @return array
     */
    public function getLocationJsonAttribute()
    {
        $result = json_decode($this->attributes['location_json']);

        return $result;
    }
    
    /**
     * Set location
     * 
     * @return void
     */
    public function setLocationJsonAttribute($value)
    {
        if(!is_string($value))
            $this->attributes['location_json'] = json_encode($value);
    }

    /**
     * Get count of all used hashtags in media
     * 
     * @return int
     */
    public function getHashtagsCountAttribute() : int
    {
        $allHashtags = array_merge($this->getCaptionHashtagsAttribute() ?? [], $this->getCommentsHashtagsAttribute() ?? []);

        return sizeof($allHashtags);
    }
    
    /**
     * Get sequences of media
     * 
     * @return int
     */
    public function getSequencesAttribute() : int
    {
        return $this->files()->count();
    }

    /**
     * Get calculated or inserted engagement rate
     * 
     * @return float
     */
    public function getCalculatedEngagementRateAttribute() : float
    {
        // Get manually inserted value
        if(!is_null($this->attributes['engagement_rate']))
            return $this->attributes['engagement_rate'];

        // Calculate engagement rate
        return $this->getEstimatedImpressionsAttribute() > 0 ? ((($this->attributes['likes'] + $this->attributes['comments']) / $this->getEstimatedImpressionsAttribute()) * 100) : 0.0;
    }

    /**
     * Get EMV
     * 
     * @return float
     */
    public function getEarnedMediaValueAttribute() : float
    {
        // Get USD/EUR exchange value
        $defaultUSDTOEURValue = env('USD2EUR');
        $USDTOEURValue = ApplicationSetting::where('key', 'usd2eur')->first();
        $defaultFacebookCostPerImpressions = config('scraper.fbcost_perimpressions');
        $FacebookCostPerImpressions = ApplicationSetting::where('key', 'fbcostperimpressions')->first();

        return ($this->getEstimatedImpressionsAttribute() * ((isset($FacebookCostPerImpressions->value) ? $FacebookCostPerImpressions->value : $defaultFacebookCostPerImpressions) * (isset($USDTOEURValue->value) ? $USDTOEURValue->value : $defaultUSDTOEURValue))) / 1000;
    }
    
    /**
     * Get image sequences of media
     * 
     * @return int
     */
    public function getImageSequencesAttribute() : int
    {
        return $this->files()->where('type', 'image')->count();
    }
    
    /**
     * Get video sequences of media
     * 
     * @return int
     */
    public function getVideoSequencesAttribute() : int
    {
        return $this->files()->where('type', 'video')->count();
    }

    /**
     * Get activated communities
     *
     * @return int
     */
    public function getActivatedCommunitiesAttribute() : int
    {
        return $this->influencer->followers;
    }

    /**
     * Get estimated impressions
     *
     * @return int
     */
    public function getEstimatedImpressionsAttribute() : int
    {
        return ($this->attributes['likes'] ?? 0) + ($this->attributes['video_views'] ?? 0);
    }
    
    /**
     * Get organic impressions
     *
     * @return int|null
     */
    public function getOrganicImpressionsAttribute() : ?int
    {
        return $this->attributes['is_ad'] ? ($this->attributes['likes'] ?? 0) + ($this->attributes['video_views'] ?? 0) : null;
    }
    
    /**
     * Get engagements
     *
     * @return int
     */
    public function getEngagementsAttribute() : int
    {
        return ($this->attributes['likes'] ?? 0) + ($this->attributes['comments'] ?? 0);
    }

    /**
     * Get media sequences
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(InfluencerPostMedia::class, 'post_id');
    }

    /**
     * Get media owner
     * 
     * @return \App\Influencer
     */
    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }
    
    /**
     * Get count of trackers related to media
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackers()
    {
        return $this->belongsToMany(Tracker::class, 'tracker_influencer_media');
    }
}
