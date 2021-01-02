<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScrapAccount extends Model
{
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'platform',
        'username',
        'email',
        'password',
        'imap_server',
        'imap_port',
        'imap_email',
        'imap_password',
        'enabled',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'enabled'       =>  'boolean',
        'updated_at'    =>  'datetime:Y-m-d H:i',
        'created_at'    =>  'datetime:Y-m-d H:i',
    ];
}
