<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class TrackerMedia extends Model
{
    use HasUuidRouteKey;

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tracker_medias';

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
        'tracker_id'    =>  'unsignedInteger'
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
}
