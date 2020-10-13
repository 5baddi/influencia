<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Campaign extends Model
{
    use HasUuidRouteKey;
    
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['posts_count', 'stories_count'];
    

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
        return $this->hasMany(Tracker::class, 'campaign_id')->with('post');
    }

    /**
     * Get posts count
     * 
     * @return int
     */
    public function getPostsCountAttribute() : int
    {
        return $this->trackers()->where('type', 'post')->count();
    }
    
    /**
     * Get stories count
     * 
     * @return int
     */
    public function getStoriesCountAttribute() : int
    {
        return $this->trackers()->where('type', 'story')->count();
    }
}