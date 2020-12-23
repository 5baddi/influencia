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
        'engagement_rate',
        'video_views',
        'impressions',
        'comments_count',
        'top_emojis',
        'sentiments_positive',
        'sentiments_neutral',
        'sentiments_negative',
        'posts_count',
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
        'video_views'           =>  'bigInteger',
        'impressions'           =>  'bigInteger',
        'comments_count'        =>  'integer',
        'posts_count'           =>  'integer',
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
}
