<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryAnalytics extends Model
{
    protected $guarded = [];

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'story_analytics';

    public function setNavigationAttribute($value)
    {
        $this->attributes['navigation'] = ($this->attributes['back'] ?? 0) + ($this->attributes['forward'] ?? 0) + ($this->attributes['next_story'] ?? 0) + ($this->attributes['exited'] ?? 0);
    }
}
