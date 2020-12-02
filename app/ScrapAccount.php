<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class ScrapAccount extends Model
{
    use HasUuidRouteKey;

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
}
