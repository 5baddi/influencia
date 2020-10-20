<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
    protected $appends = ['posts_count', 'stories_count', 'urls_count', 'all_posts_count', 'sentiments_positive', 'sentiments_neutral', 'sentiments_negative', 'top_three_emojis'];
    

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

    public function getAllPostsCountAttribute() : int
    {
        return $this->getStoriesCountAttribute() + $this->getPostsCountAttribute() + $this->getUrlsCountAttribute();
    }

    public function getSentimentsPositiveAttribute() : float
    {
        $semtiments = 0.0;
        $allCount = $this->getAllPostsCountAttribute();
        $trackers = $this->trackers()->get();

        foreach($trackers as $tracker){
            if($tracker->posts->count() === 0)
                continue;

            foreach($tracker->posts as $post){
                $semtiments += $post->comments_positive;
            }
        }

        return $allCount > 0 ? $semtiments / $allCount : 0;
    }
    
    public function getSentimentsNeutralAttribute() : float
    {
        $semtiments = 0.0;
        $allCount = $this->getAllPostsCountAttribute();
        $trackers = $this->trackers()->get();

        foreach($trackers as $tracker){
            if($tracker->posts->count() === 0)
                continue;

            foreach($tracker->posts as $post){
                $semtiments += $post->comments_neutral;
            }
        }

        return $allCount > 0 ? $semtiments / $allCount : 0;
    }
    
    public function getSentimentsNegativeAttribute() : float
    {
        $semtiments = 0.0;
        $allCount = $this->getAllPostsCountAttribute();
        $trackers = $this->trackers()->get();

        foreach($trackers as $tracker){
            if($tracker->posts->count() === 0)
                continue;

            foreach($tracker->posts as $post){
                $semtiments += $post->comments_negative;
            }
        }

        return $allCount > 0 ? $semtiments / $allCount : 0;
    }

    public function getTopThreeEmojisAttribute() : array
    {
        $topThreeEmojis = [];
        $emojisCount = 0;
        $trackers = $this->trackers()->get();

        foreach($trackers as $tracker){
            if($tracker->posts->count() === 0)
                continue;

            foreach($tracker->posts as $post){
                $emojis = json_decode(json_encode($post->comments_emojis), true);
                if(is_null($emojis) || empty($emojis))
                    continue;

                $topThreeEmojis = array_merge($topThreeEmojis, $emojis);
                $emojisCount += sizeof($emojis);
            }
        }

        // Ignore empty emojis list
        if(is_null($topThreeEmojis) || empty($topThreeEmojis))
            return $topThreeEmojis;

        $topThreeEmojis = array_flip(array_count_values($topThreeEmojis));
        // Sort emojis desc
        krsort($topThreeEmojis);

        // Slice top emojis
        return [
            'top'   =>  array_slice($topThreeEmojis, 0, 3, true),
            'all'   =>  $emojisCount
        ];
    }
}