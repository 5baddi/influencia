<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkVisit extends Model
{
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'link_visits';

    /**
     * Get short link
     *
     * @return \App\ShortLink
     */
    public function shortLink()
    {
        return $this->belongsTo(ShortLnk::class);
    }
}
