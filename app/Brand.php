<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Brand extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'brand_user');
    }
    
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
