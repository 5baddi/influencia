<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CheckAbilities
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get user
        $user = Auth::user();

        if($user){
            $roles = Role::with('permissions')->get();
            $permissions = [];

            foreach($roles as $role){
                foreach($role->permissions as $permission){
                    $permissions[$permission->name] = $role->name;
                }
            }

            foreach($permissions as $name => $roles){
                Gate::define($name, function(User $user) use ($name){
                    // Super admin
                    if($user->is_superadmin)
                        return true;

                    // Set abilities
                    if($user->role){
                        $userPermissions = $user->role->permissions->pluck('name')->toArray();
                        return in_array($name, $userPermissions);
                    }
                });
            }
        }

        return $next($request);
    }
}
