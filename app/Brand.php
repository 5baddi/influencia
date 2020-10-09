<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Brand extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * Get users
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'brand_user');
    }
    
    /**
     * Get campaigns
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
