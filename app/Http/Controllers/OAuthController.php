<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PermissionRequest;

class OAuthController extends Controller
{
    public function abilities()
    {
        // Load data
        $permissions = auth()->user()->role()
                            ->with('permissions')
                            ->get()
                            ->pluck('permissions')
                            ->flatten()
                            ->pluck('name')
                            ->toArray();

        // Format permissions to rules
        $rules = array_map(function($item){
            $exploded = explode('_', $item);
            if(!isset($exploded[0], $exploded[1]))
                return;

            return ['action' => $exploded[0], 'subject' => $exploded[1]];
        }, $permissions);

        return response()->success(
            "Abilities feteched successfully.",
            $rules
        );
    }

    /**
     * Store new role
     * 
     * @param \App\Http\Requests\RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeRole(RoleRequest $request)
    {
        // Create new role
        $role = Role::create($request->validated());

        return response()->success("Role '{$role->name}' successfully created.", $role->toArray());
    }
    
    /**
     * Store new permission
     * 
     * @param \App\Http\Requests\PermissionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storePermission(PermissionRequest $request)
    {
        // Create new permission
        $permission = Permission::create($request->validated());

        return response()->success("Permission '{$permission->name}' successfully created.", $permission->toArray());
    }

    /**
     * List roles
     * 
     * @return \Illuminate\Http\Response
     */
    public function roles()
    {
        return response()->success(
            "Roles fetched successfully.",
            Role::all()
        );
    }

    /**
     * Sign in layout
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function signInLayout()
    {
        return view("v2.signin");
    }

    /**
     * Sign in with an user
     *
     * @return @return \Illuminate\Http\Response
     */
    public function signIn()
    {
        // Validate sign in data
        $data = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        // Load user
        $user = User::where('email', $request->email)->first();

        // Verify credentials
        if(!$user || !Hash::check($request->password, $user->password))
            return response()->error("These credentials do not match our records.", [], 404);

        // Generate new token
        $token = $user->createToken('influencia')->plainTextToken;

        // Update last login
        $user->update([
            'last_login' => now()
        ]);

        return response()->success(
            ucwords($user->name) . " sign in successfully.", 
            [
                'user'  => $user->load(['selectedBrand', 'brands']),
                'token' => $token
            ]
        );
    }

    /**
     * Sign out authenticated user
     *
     * @return @return \Illuminate\Http\Response
     */
    public function signOut()
    {
        // Get authenticated user
        $user = Auth::user();

        // Clear tokens 
        if($user)
            $user->tokens()->delete();

        return response()->success(ucwords($user->name) . " signed out.");
    }
}
