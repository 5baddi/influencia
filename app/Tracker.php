<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Tracker extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'engagements',
        'organic_engagements',
        'views',
        'organic_views',
        'impressions',
        'organic_impressions',
        'communities',
        'organic_communities',
        'posts_count',
        'organic_posts',
        'comments_count',
        'top_three_emojis',
        'sentiments_positive',
        'sentiments_neutral',
        'sentiments_negative',
    ];

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
     * Get tracker engagements
     *
     * @return int
     */
    public function getEngagementsAttribute() : int
    {
        $engagement = 0;

        foreach($this->posts as $post)
            $engagement += $post->likes + $post->comments;

        return $engagement;
    }

    /**
     * Get organic engagements
     *
     * @return int
     */
    public function getOrganicEngagementsAttribute() : int
    {
        $engagement = 0;

        foreach($this->posts as $post){
            if($post->is_ad)
                continue;

            $engagement += $post->likes + $post->comments;
        }

        return $engagement;
    }

    /**
     * Get videos views 
     *
     * @return int
     */
    public function getViewsAttribute() : int
    {
        $views = 0;

        foreach($this->posts as $post)
            $views += $post->video_views;

        return $views;
    }

    /**
     * Get organic videos views
     *
     * @return int
     */
    public function getOrganicViewsAttribute() : int
    {
        $views = 0;

        foreach($this->posts as $post){
            if($post->is_ad)
                continue;

            $views += $post->video_views;
        }

        return $views;
    }

    /**
     * Get impressions
     *
     * @return int
     */
    public function getImpressionsAttribute() : int
    {
        $impressions = 0;

        foreach($this->posts as $post)
            $impressions += $post->likes + $post->video_views;

        return $impressions;
    }

    /**
     * Get organic impressions
     *
     * @return int
     */
    public function getOrganicImpressionsAttribute() : int
    {
        $impressions = 0;

        foreach($this->posts as $post){
            if($post->is_ad)
                continue;

            $impressions += $post->likes + $post->video_views;
        }

        return $impressions;
    }

    /**
     * Get size of activated communities
     *
     * @return int
     */
    public function getCommunitiesAttribute() : int
    {
        $communities = 0;

        foreach($this->posts->load('influencer') as $post)
            $communities += $post->influencer->followers;

        return $communities;
    }

    /**
     * Get size of origanic activated communities
     *
     * @return int
     */
    public function getOrganicCommunitiesAttribute() : int
    {
        $communities = 0;

        foreach($this->posts as $post){
            if($post->is_ad)
                continue;

            $communities += $post->likes + $post->comments;
        }

        return $communities;
    }

    /**
     * Get posts count
     *
     * @return int
     */
    public function getPostsCountAttribute() : int
    {
        if($this->attributes['type'] !== 'post')
            return 0;

        return $this->posts->count();
    }

    
    /**
     * Get comments count
     *
     * @return int
     */
    public function getCommentsCountAttribute() : int
    {
        $count = 0;

        foreach($this->posts as $post){
            $count += $post->comments;
        }

        return $count;
    }

    /**
     * Get top three emojis
     * 
     * @return array
     */
    public function getTopThreeEmojisAttribute() : array
    {
        $topThreeEmojis = [];
        $emojisCount = 0;

        foreach($this->posts as $post){
            $emojis = json_decode(json_encode($post->comments_emojis), true);
            if(is_null($emojis) || empty($emojis))
                continue;

            $topThreeEmojis = array_merge($topThreeEmojis, $emojis);
            $emojisCount += sizeof($emojis);
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
     * Get percentage of positive semtiments
     *
     * @return float
     */
    public function getSentimentsPositiveAttribute() : float
    {
        $semtiments = 0.0;

        foreach($this->posts as $post){
            $semtiments += $post->comments_positive;
        }

        return $this->posts->count() > 0 ? $semtiments / $this->posts->count() : 0;
    }

    /**
     * Get percentage of neutral semtiments
     *
     * @return float
     */
    public function getSentimentsNeutralAttribute() : float
    {
        $semtiments = 0.0;

        foreach($this->posts as $post){
            $semtiments += $post->comments_neutral;
        }

        return $this->posts->count() > 0 ? $semtiments / $this->posts->count() : 0;
    }

    /**
     * Get percentage of negative semtiments
     *
     * @return float
     */
    public function getSentimentsNegativeAttribute() : float
    {
        $semtiments = 0.0;

        foreach($this->posts as $post){
            $semtiments += $post->comments_negative;
        }

        return $this->posts->count() > 0 ? $semtiments / $this->posts->count() : 0;
    }

    /**
     * Get organic posts count
     *
     * @return int
     */
    public function getOrganicPostsAttribute() : int
    {
        $posts = 0;

        foreach($this->posts as $post){
            if($post->is_ad)
                continue;

            ++$posts;
        }

        return $posts;
    }
}
