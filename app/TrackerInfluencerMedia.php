<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackerInfluencerMedia extends Model
{
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tracker_influencer_media';

    public $timestamps = false;
}
