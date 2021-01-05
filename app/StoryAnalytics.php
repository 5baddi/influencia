<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoryAnalytics extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'story_analytics';
}
