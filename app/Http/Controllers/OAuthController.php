<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
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
        $role = Role::create($request->all());

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
        $permission = Permission::create($request->all());

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
}
