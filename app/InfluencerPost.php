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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['hashtags_count', 'sequences', 'image_sequences', 'video_sequences'];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'caption_hashtags'       =>  'json',
        'comments_emojis'        =>  'json',
        'comments_hashtags'      =>  'json',
        'location_json'          =>  'json',
    ];

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
     * Get Hashtags list
     * 
     * @return array
     */
    public function getCommentsHashtagsAttribute()
    {
        $result = json_decode($this->attributes['comments_hashtags']);

        return $result;
    }
    
    /**
     * Set Hashtags list
     * 
     * @return void
     */
    public function setCommentsHashtagsAttribute($value)
    {
        if(!is_string($value))
            $this->attributes['comments_hashtags'] = json_encode($value);
    }
    
    /**
     * Get Hashtags list
     * 
     * @return array
     */
    public function getCaptionHashtagsAttribute()
    {
        $result = json_decode($this->attributes['caption_hashtags']);

        return $result;
    }
    
    /**
     * Set Hashtags list
     * 
     * @return void
     */
    public function setCaptionHashtagsAttribute($value)
    {
        if(!is_string($value))
            $this->attributes['caption_hashtags'] = json_encode($value);
    }

    /**
     * Get count of all used hashtags in media
     * 
     * @return int
     */
    public function getHashtagsCountAttribute() : int
    {
        $allHashtags = array_merge($this->getCaptionHashtagsAttribute() ?? [], $this->getCommentsHashtagsAttribute() ?? []);

        return sizeof($allHashtags);
    }
    
    /**
     * Get sequences of media
     * 
     * @return int
     */
    public function getSequencesAttribute() : int
    {
        return $this->files()->count();
    }
    
    /**
     * Get image sequences of media
     * 
     * @return int
     */
    public function getImageSequencesAttribute() : int
    {
        return $this->files()->where('type', 'image')->count();
    }
    
    /**
     * Get video sequences of media
     * 
     * @return int
     */
    public function getVideoSequencesAttribute() : int
    {
        return $this->files()->where('type', 'video')->count();
    }

    /**
     * Get media sequences
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(InfluencerPostMedia::class, 'post_id');
    }

    /**
     * Get media owner
     * 
     * @return \App\Influencer
     */
    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }
    
    /**
     * Get tracker
     * 
     * @return \App\Tracker
     */
    public function tracker()
    {
        return $this->belongsTo(Tracker::class, 'tracker_id');
    }
}
