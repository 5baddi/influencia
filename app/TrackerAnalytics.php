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
        'organic_communities',
        'engagements',
        'organic_engagements',
        'video_views',
        'organic_video_views',
        'impressions',
        'organic_impressions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tracker_id'            =>  'unsignedInteger',
        'communities'           =>  'bigInteger',
        'organic_communities'   =>  'bigInteger',
        'engagements'           =>  'bigInteger',
        'organic_engagements'   =>  'bigInteger',
        'video_views'           =>  'bigInteger',
        'organic_video_views'   =>  'bigInteger',
        'impressions'           =>  'bigInteger',
        'organic_impressions'   =>  'bigInteger',
        'updated_at'            =>  'datetime:Y-m-d H:i',
        'created_at'            =>  'datetime:Y-m-d H:i',
    ];
}
