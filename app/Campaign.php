<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Campaign extends Model
{
    use HasUuidRouteKey;
    
    protected $guarded = [];

    /**
     * Get user
     * 
     * @return \App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get brand
     * 
     * @return \App\Brand
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get campaign trackers
     * 
     * @return \App\Tracker[]
     */
    public function trackers()
    {
        return $this->hasMany(Tracker::class, 'campaign_id');
    }
}
