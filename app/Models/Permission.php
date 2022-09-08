<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;

class Permission extends Model
{
    use HasUuidRouteKey;
    
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
