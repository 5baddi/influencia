<?php

namespace App;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'campaign_id',
        'platform',
        'name',
        'type',
        'username',
        'url',
        'nbr_squences',
        'nbr_squences_impressions',
        'nbr_impressions_first_sequence',
        'reach_first_sequence',
        'sticker_taps_mentions',
        'sticker_taps_hashtags',
        'link_clicks',
        'nbr_replies',
        'nbr_taps_forward',
        'nbr_taps_backward',
        'posted_date',
        'posted_hour',
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'       =>  'unsignedInteger',
        'campaign_id'   =>  'unsignedInteger',
        'posted_date'   =>  'date',
        'posted_time'   =>  'time'
    ];

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
