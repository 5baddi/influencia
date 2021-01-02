<?php

namespace App;

use App\Tracker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Influencer extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'platform',
        'username',
        'biography',
        'website',
        'name',
        'is_business',
        'is_private',
        'is_verified',
        'medias',
        'follows',
        'followers',
        'pic_url',
        'banned',
        'engagement_rate',
        'queued',
        'highlight_reel',
        'business_category',
        'business_email',
        'business_phone',
        'business_address'
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_business'       =>  'boolean',
        'is_private'        =>  'boolean',
        'banned'            =>  'boolean',
        'business_address'  =>  'json',
        'updated_at'        =>  'datetime:Y-m-d H:i',
        'created_at'        =>  'datetime:Y-m-d H:i',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'link',
        'calculated_engagement_rate',
        'image_sequences',
        'video_sequences',
        'carousel_sequences',
        'likes',
        'video_views',
        'comments',
        'active_posts_count',
        'estimated_impressions',
        'estimated_communities',
        'earned_media_value'
    ];

    /**
     * Get media link
     * 
     * @return string|null
     */
    public function getLinkAttribute() : ?string
    {
        // Init
        $link = null;

        if(isset($this->attributes['platform'])){
            switch($this->attributes['platform']){
                case "youtube":
                    $link = "https://www.youtube.com/channel/" . $this->attributes['account_id'];
                break;
                case "instagram":
                    $link = "https://www.instagram.com/" . $this->attributes['username'];
                break;
            }
        }
        
        return $link;
    }
    
    /**
     * Get business email attribute
     * 
     * @return string|null
     */
    public function getBusinessEmailAttribute() : ?string
    {
        if(isset($this->attributes['business_email']) || $this->attributes['platform'] !== 'instagram')
            return $this->attributes['business_email'];

        // Get email from biography
        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $this->attributes['biography'] ?? '', $matches);
        
        return $matches[0] ?? null;
    }

    /**
     * Get likes of an infleuncer
     *
     * @return int
     */
    public function getLikesAttribute() : int
    {
        return $this->posts()->sum('likes');
    }

    /**
     * Get comments of an infleuncer
     *
     * @return int
     */
    public function getCommentsAttribute() : int
    {
        return $this->posts()->sum('comments');
    }

    /**
     * Get video views of an infleuncer
     *
     * @return int
     */
    public function getVideoViewsAttribute() : int
    {
        return $this->posts()->sum('video_views');
    }

    /**
     * Get image status sequences of an infleuncer
     *
     * @return int
     */
    public function getImageSequencesAttribute() : int
    {
        return $this->posts()->where('type', 'image')->count();
    }

    /**
     * Get video status sequences of an infleuncer
     *
     * @return int
     */
    public function getVideoSequencesAttribute() : int
    {
        return $this->posts()->where('type', 'video')->count();
    }

    /**
     * Get carousel status sequences of an infleuncer
     *
     * @return int
     */
    public function getCarouselSequencesAttribute() : int
    {
        return $this->posts()->whereIn('type', ['sidecar', 'carousel'])->count();
    }

    /**
     * Get posts count of an infleuncer
     *
     */
    public function getActivePostsCountAttribute()
    {
        return $this->posts()->count();
    }

    /**
     * Get estimated impressions for all posts
     *
     */
    public function getEstimatedCommunitiesAttribute()
    {
        return $this->attributes['followers'];
    }

    /**
     * Get estimated communities for all posts
     *
     */
    public function getEstimatedImpressionsAttribute()
    {
        return  $this->getLikesAttribute() + $this->getVideoViewsAttribute();
    }

    /**
     * Get calculated or inserted engagement rate
     *
     * @return float
     */
    public function getCalculatedEngagementRateAttribute() : float
    {
        // Get manually inserted value
        if(isset($this->attributes['engagement_rate']))
            return $this->attributes['engagement_rate'];

        // Calculate engagement rate
        return $this->attributes['followers'] > 0 ? ((($this->getLikesAttribute() + $this->getCommentsAttribute()) / $this->attributes['followers']) * 100) : 0.0;
    }

     /**
     * Get EMV
     *
     * @return float
     */
    public function getEarnedMediaValueAttribute() : float
    {
        // Get USD/EUR exchange value
        $defaultUSDTOEURValue = config('scraper.usd2eur');
        $USDTOEURValue = ApplicationSetting::where('key', 'usd2eur')->first();
        $defaultFacebookCostPerImpressions = config('scraper.fbcost_perimpressions');
        $FacebookCostPerImpressions = ApplicationSetting::where('key', 'fbcostperimpressions')->first();

        return ($this->getEstimatedImpressionsAttribute() * ((isset($FacebookCostPerImpressions->value) ? $FacebookCostPerImpressions->value : $defaultFacebookCostPerImpressions) * (isset($USDTOEURValue->value) ? $USDTOEURValue->value : $defaultUSDTOEURValue))) / 1000;
    }

    /**
     * Get post medias
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(InfluencerPost::class);
    }

    /**
     * Get count of trackers related to influencer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackers()
    {
        return $this->belongsToMany(Tracker::class, 'tracker_influencers');
    }
}
