<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackerAnalytics extends Model
{
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tracker_analytics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tracker_id',
        'communities',
        'engagements',
        'engagement_rate',
        'video_views',
        'impressions',
        'comments',
        'top_emojis',
        'sentiments_positive',
        'sentiments_neutral',
        'sentiments_negative'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tracker_id'            =>  'unsignedInteger',
        'communities'           =>  'bigInteger',
        'engagements'           =>  'bigInteger',
        'video_views'           =>  'bigInteger',
        'impressions'           =>  'bigInteger',
        'comments'              =>  'integer',
        'top_emojis'            =>  'json',
        'sentiments_positive'   =>  'double',
        'sentiments_neutral'    =>  'double',
        'sentiments_negative'   =>  'double',
        'engagement_rate'       =>  'double',
        'updated_at'            =>  'datetime:Y-m-d H:i',
        'created_at'            =>  'datetime:Y-m-d H:i',
    ];
}
