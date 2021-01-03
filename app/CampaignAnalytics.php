<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignAnalytics extends Model
{
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campaign_analytics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'communities',
        'engagements',
        'organic_engagements',
        'engagement_rate',
        'video_views',
        'organic_video_views',
        'impressions',
        'organic_impressions',
        'comments_count',
        'top_emojis',
        'sentiments_positive',
        'sentiments_neutral',
        'sentiments_negative',
        'posts_count',
        'organic_posts',
        'stories_count',
        'links_count',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'campaign_id'           =>  'unsignedInteger',
        'communities'           =>  'bigInteger',
        'engagements'           =>  'bigInteger',
        'organic_engagements'   =>  'bigInteger',
        'video_views'           =>  'bigInteger',
        'organic_video_views'   =>  'bigInteger',
        'impressions'           =>  'bigInteger',
        'organic_impressions'   =>  'bigInteger',
        'comments_count'        =>  'integer',
        'posts_count'           =>  'integer',
        'organic_posts'         =>  'integer',
        'stories_count'         =>  'integer',
        'links_count'           =>  'integer',
        'top_emojis'            =>  'json',
        'sentiments_positive'   =>  'double',
        'sentiments_neutral'    =>  'double',
        'sentiments_negative'   =>  'double',
        'engagement_rate'       =>  'double',
        'updated_at'            =>  'datetime:Y-m-d H:i',
        'created_at'            =>  'datetime:Y-m-d H:i',
    ];

    /**
     * Get top emojis array with keys
     *
     * @return array
     */
    public function getTopEmojisAttribute() : array
    {
        if(isset($this->attribute['top_emojis']))
            return json_decode($this->attribute['top_emojis'], true);

        return [];
    }
}
