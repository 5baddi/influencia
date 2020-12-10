<?php

namespace App;

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
        'posts_count',
        'stories_count',
        'urls_count',
        'all_posts_count',
        'instagram_posts',
        'sentiments_positive',
        'sentiments_neutral',
        'sentiments_negative',
        'top_three_emojis',
        'engagements',
        'organic_engagements',
        'views',
        'organic_views',
        'impressions',
        'organic_impressions',
        'communities',
        'organic_communities',
        'influencers',
        'comments_count',
        'all_trackers_count',
        'organic_posts',
        'visits_evolution',
        'tracker_posts'
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

    public function getVisitsEvolutionAttribute()
    {
        // TODO: Get visits
    }

    /**
     * Get all trackers count
     *
     * @return int
     */
    public function getAllTrackersCountAttribute() : int
    {
        return $this->hasMany(Tracker::class, 'campaign_id')->count();
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

    /**
     * Get comments count
     *
     * @return int
     */
    public function getCommentsCountAttribute() : int
    {
        $count = 0;

        foreach($this->trackers as $tracker){
            if(!$tracker->comments_count)
                continue;

            $count += $tracker->comments_count;
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
            'top'   =>  array_slice($topThreeEmojis, 0, sizeof($topThreeEmojis) < 3 ? sizeof($topThreeEmojis) : 3, true),
            'all'   =>  $emojisCount
        ];
    }

    /**
     * Get number of engagement
     *
     * @return int
     */
    public function getEngagementsAttribute() : int
    {
        $engagement = 0;

        foreach($this->trackers as $tracker){
            if(!$tracker->engagement)
                continue;

            $engagement += $tracker->engagement;
        }

        return $engagement;
    }

    /**
     * Get number of views for this campaign videos
     *
     * @return int
     */
    public function getViewsAttribute() : int
    {
        $views = 0;

        foreach($this->trackers as $tracker){
            if(!$tracker->views)
                continue;

            $views += $tracker->views;
        }

        return $views;
    }

    /**
     * Get campaign number of impressions
     *
     * @return int
     */
    public function getImpressionsAttribute() : int
    {
        $impressions = 0;

        foreach($this->trackers as $tracker){
            if(!$tracker->impressions)
                continue;

            $impressions += $tracker->impressions;
        }

        return $impressions;
    }

    /**
     * Get number of communities
     *
     * @return int
     */
    public function getCommunitiesAttribute() : int
    {
        $communities = 0;

        foreach($this->trackers as $tracker){
            if(!$tracker->communities)
                continue;

            $communities += $tracker->communities;
        }

        return $communities;
    }

    /**
     * Get number of organic posts
     *
     * @return int
     */
    public function getOrganicPostsAttribute() : int
    {
        $posts = 0;

        foreach($this->trackers as $tracker){
            if(!$tracker->organic_posts)
                continue;

            $posts += $tracker->organic_posts;
        }

        return $posts;
    }

    public function getOrganicCommunitiesAttribute()
    {
        $communities = 0;

        foreach($this->trackers->load('posts') as $tracker){
            if(is_null($tracker->posts))
                continue;

            foreach($tracker->posts as $post){
                if($post->is_ad)
                    continue;

                $communities += $post->likes + $post->comments;
            }
        }

        return $communities;
    }

    public function getOrganicEngagementsAttribute()
    {
        $engagement = 0;

        foreach($this->trackers->load('posts') as $tracker){
            if(is_null($tracker->posts))
                continue;

            foreach($tracker->posts as $post){
                if($post->is_ad)
                    continue;

                $engagement += $post->likes + $post->comments;
            }
        }

        return $engagement;
    }

    public function getOrganicImpressionsAttribute()
    {
        $impressions = 0;

        foreach($this->trackers->load('posts') as $tracker){
            if(is_null($tracker->posts))
                continue;

            foreach($tracker->posts as $post){
                if($post->is_ad)
                    continue;

                $impressions += $post->likes + $post->video_views;
            }
        }

        return $impressions;
    }

    public function getOrganicViewsAttribute()
    {
        $views = 0;

        foreach($this->trackers->load('posts') as $tracker){
            if(is_null($tracker->posts))
                continue;

            foreach($tracker->posts as $post){
                if($post->is_ad)
                    continue;

                $views += $post->video_views;
            }
        }

        return $views;
    }

    public function getInfluencersAttribute()
    {
        $influencers = collect();

        foreach($this->trackers->load('posts') as $tracker){
            if(is_null($tracker->posts))
                continue;

            foreach($tracker->posts->load('influencer') as $post){
                if($influencers->contains('id', $post->influencer->id))
                    continue;

                $influencers->add($post->influencer);
            }
        }

        return $influencers;
    }
    
    /**
     * Merge trackers posts in one collection
     * 
     * @return mixed
     */
    public function getTrackerPostssAttribute()
    {
        $posts = collect();

        foreach($this->trackers->load('posts') as $tracker){
            if(is_null($tracker->posts))
                continue;

            foreach($tracker->posts as $post){
                if($posts->contains('id', $post->id))
                    continue;

                $posts->add($post);
            }
        }

        return $posts;
    }

    public function getInstagramPostsAttribute()
    {
        $posts = collect();

        foreach($this->trackers->where('platform', 'instagram')->load('posts') as $tracker){
            if(is_null($tracker->posts) || $tracker->type === 'url')
                continue;

            if($tracker->type === 'story'){
                if($posts->contains('id', $tracker->id))
                    continue;

                $posts->add($tracker->load('influencer'));

                continue;
            }

            foreach($tracker->posts->load('influencer') as $post){
                if($posts->contains('id', $post->id))
                    continue;

                $posts->add($post);
            }
        }

        return $posts;
    }
}
