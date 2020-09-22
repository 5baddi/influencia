<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class BrandUser extends Model
{
    use HasUuidRouteKey;
    
    protected $guarded = [];
}
