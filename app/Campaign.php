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
    protected $appends = ['posts_count', 'stories_count', 'urls_count'];
    

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
     * Get posts count
     * 
     * @return int
     */
    public function getPostsCountAttribute() : int
    {
        $trackers = $this->trackers()->where('type', 'post')->withCount('posts')->get();

        $count = 0;
        foreach($trackers as $tracker){
            if(!isset($tracker->posts_count))
                continue;

            $count += $tracker->posts_count;
        }

        return $count;
    }
    
    /**
     * Get stories count
     * 
     * @return int
     */
    public function getStoriesCountAttribute() : int
    {
        $trackers = $this->trackers()->where('type', 'story')->withCount('posts')->get();

        $count = 0;
        foreach($trackers as $tracker){
            if(!isset($tracker->posts_count))
                continue;

            $count += $tracker->posts_count;
        }

        return $count;
    }
    
    /**
     * Get urls count
     * 
     * @return int
     */
    public function getUrlsCountAttribute() : int
    {
        $trackers = $this->trackers()->where('type', 'url')->withCount('posts')->get();

        $count = 0;
        foreach($trackers as $tracker){
            if(!isset($tracker->posts_count))
                continue;

            $count += $tracker->posts_count;
        }

        return $count;
    }
}