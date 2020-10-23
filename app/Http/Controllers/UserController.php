<?php

namespace App\Http\Controllers;

use App\User;
use App\Brand;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Create new user
     * 
     * @param \App\Http\Requests\CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        // Get data
        $data = $request->validated();

        // Hash the password
        $data['password'] = Hash::make($data['password']);

        // Set user role
        if(is_string($request->input('role')) && $request->input('role') == "super")
            $data['is_superadmin'] = true;
        else
            $data['role_id'] = $request->input('role');

        // Create user row
        $user = User::create($data);

        // Attach brand 
        if($request->get('brand_id') && !$user->is_superadmin){
            $brand = Brand::find($request->get('brand_id'));
            $user->brands()->attach($brand);
            $user->update(['selected_brand_id' => $brand->id]);
        }

        // Attach all brands to Admin
        if($user->is_superadmin)
            $user->brands()->attach(Brand::all());

        return response()->success("User created successfully.", $user->load('brands'), 201);
    }

    /**
     * List users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('viewAny', Auth::user()) && Gate::denies('list_user'), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return response()->success("Users fetched successfully.", User::with(['brands', 'role'])->get());
    }

    /**
     * View user
     * 
     * @param \App\User $users
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('show_user') && Gate::denies('view', $user), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return response()->success("User fetched successfully.", $user->load('brands'));
    }

    /**
     * Delete user
     * 
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {
        abort_if(Gate::denies('delete_user') && Gate::denies('delete', $user), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Delete user row
        $user->delete();

        return response()->success("User deleted successfully.", [], 204);
    }
}
