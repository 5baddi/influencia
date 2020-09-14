<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
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
