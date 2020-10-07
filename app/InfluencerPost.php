<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class InfluencerPost extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'influencer_posts';

    /**
     * Get Emojis list
     * 
     * @return array
     */
    public function getCommentsEmojisAttribute()
    {
        return json_decode($this->comments_emojis);
    }

    public function files()
    {
        return $this->hasMany(InfluencerPostMedia::class, 'influencer_post_id');
    }
}
