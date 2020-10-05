<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class InfluencerPost extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];
}
