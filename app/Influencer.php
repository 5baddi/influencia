<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Influencer extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'platform',
        'username',
        'biography',
        'website',
        'name',
        'is_business',
        'is_private',
        'is_verified',
        'posts',
        'follows',
        'followers',
        'pic_url',
        'banned'
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_business'       =>  'boolean',
        'is_private'        =>  'boolean',
        'banned'            =>  'boolean',
        'business_address'  =>  'json',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_sequences', 'video_sequences', 'carousel_sequences', 'likes', 'comments'];
    
    /**
     * Get likes of an infleuncer
     * 
     * @return int
     */
    public function getLikesAttribute() : int
    {
        return $this->statues()->sum('likes');
    }
    
    /**
     * Get comments of an infleuncer
     * 
     * @return int
     */
    public function getCommentsAttribute() : int
    {
        return $this->statues()->sum('comments');
    }

    /**
     * Get image status sequences of an infleuncer
     * 
     * @return int
     */
    public function getImageSequencesAttribute() : int
    {
        return $this->statues()->where('type', 'image')->count();
    }
    
    /**
     * Get video status sequences of an infleuncer
     * 
     * @return int
     */
    public function getVideoSequencesAttribute() : int
    {
        return $this->statues()->where('type', 'video')->count();
    }
    
    /**
     * Get carousel status sequences of an infleuncer
     * 
     * @return int
     */
    public function getCarouselSequencesAttribute() : int
    {
        return $this->statues()->whereIn('type', ['sidecar', 'carousel'])->count();
    }

    /**
     * Get post medias
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statues()
    {
        return $this->hasMany(InfluencerPost::class);
    }
}
