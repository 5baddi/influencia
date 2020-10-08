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
        $result = json_decode($this->attributes['comments_emojis']);
        if(is_array($result) && sizeof($result) > 0)
            krsort($result);

        return $result;
    }
    
    /**
     * Set Emojis list
     * 
     * @return void
     */
    public function setCommentsEmojisAttribute($value)
    {
        if(!is_string($value))
            $this->attributes['comments_emojis'] = json_encode($value);
    }

    /**
     * Get media sequences
     * 
     * @return InfluencerPostMedia[]
     */
    public function files()
    {
        return $this->hasMany(InfluencerPostMedia::class, 'post_id');
    }

    /**
     * Get media owner
     * 
     * @return Influencer
     */
    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }
}
