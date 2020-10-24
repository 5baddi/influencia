<?php

namespace App;

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'short_link_id',
        'ip',
        'device',
        'os',
        'os_version',
        'browser',
        'browser_version',
        'referer',
        'is_mobile',
        'views',
        'last_visit',
        'country_code',
        'country_name',
        'city_name',
        'zip_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'short_lint_id'       =>  'unsignedInteger',
        'last_visit'          =>  'timestamp',
    ];
}
