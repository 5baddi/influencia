<?php

namespace App\Models;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'top_emojis'  =>  'json',
    ];

    

    /**
     * Get top emojis array with keys
     *
     * @return array
     */
    public function getTopEmojisAttribute() : array
    {
        if(isset($this->attributes['top_emojis']))
            return json_decode($this->attributes['top_emojis'], true);

        return [];
    }
}
