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
                Gate::define($name, function(User $user) use ($permissions){
                    $user = $user->role->load('permissions')->get();
                    return in_array($user->permissions->pluck('name')->toArray(), $permissions);
                });
            }
        }

        return $next($request);
    }
}
