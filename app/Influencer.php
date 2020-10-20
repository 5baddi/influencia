<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
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
        'posts',
        'follows',
        'followers',
        'pic_url',
        'banned'
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
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_sequences', 'video_sequences', 'carousel_sequences', 'likes', 'comments', 'posts_count', 'estimated_impressions', 'estimated_communities'];
    
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
    public function getPostsCountAttribute()
    {
        return $this->posts()->whereNotNull('tracker_id');
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
        $impressions = 0;

        foreach($this->posts() as $post){
            $impressions += ($post->likes + $post->video_views);
        }

        return $impressions;
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
}
