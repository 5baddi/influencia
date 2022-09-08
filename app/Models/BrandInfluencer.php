<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandInfluencer extends Model
{
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'brand_influencers';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'influencer_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'brand_id'       =>  'unsignedInteger',
        'influencer_id'  =>  'unsignedInteger',
    ];
}
