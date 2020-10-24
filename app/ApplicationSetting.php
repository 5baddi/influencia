<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationSetting extends Model
{
    const DEFAULT_PAGINATION = 100;

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'application_settings';
}
