<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class ShortLink extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'short_links';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tracker_id',
        'code',
        'link',
        'title',
        'meta_description',
        'meta_keywords',
        'tags',
        'top_image_url'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tracker_id'       =>  'unsignedInteger',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'fulllink'
    ];

    /**
     * Get tracker
     *
     * @return \App\Tracker
     */
    public function tracker()
    {
        return $this->belongsTo(Tracker::class);
    }

    /**
     * Get Visis
     *
     * @return \App\LinkVisit
     */
    public function visits()
    {
        return $this->hasMany(LinkVisit::class, 'short_link_id', 'id');
    }

    /**
     * Get full shortlink
     *
     * @return string
     */
    public function getFulllinkAttribute() : ?string
    {
        return url('/u/' . $this->attributes['code']);
    }
}
