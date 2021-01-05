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
