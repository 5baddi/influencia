<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackerInfluencer extends Model
{
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tracker_influencers';

    public $timestamps = false;
}
