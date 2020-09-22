<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class TrackerMedias extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tracker_id',
        'name',
        'type',
        'media_path'
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tracker_id'   =>  'unsignedInteger'
    ];
    
    public function tracker()
    {
        return $this->belongsTo(Tracker::class);
    }
}
