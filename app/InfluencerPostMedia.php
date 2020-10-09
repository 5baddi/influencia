<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfluencerPostMedia extends Model
{
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'influencer_post_medias';

    public function status()
    {
        return $this->belongsTo(InfluencerPost::class, 'post_id');
    }
}
