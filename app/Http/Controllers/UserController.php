<?php

namespace App\Http\Controllers;

use App\User;
use App\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ResetUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
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

        return response()->success("User created successfully.", User::with(['role', 'brands'])->find($user->id), 201);
    }

    /**
     * Update exists user
     *
     * @param \App\User $user
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        abort_if(Gate::denies('update', $user), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Get data
        $data = $request->validated();

        // Set user role
        if(is_string($request->input('role')) && $request->input('role') == "super")
            $data['is_superadmin'] = true;
        else
            $data['role_id'] = $request->input('role');

        // Update user row
        $updated = $user->update($data);

        if($updated){
            // Attach brand
            if($request->get('brand_id') && !$user->is_superadmin){
                $brand = Brand::find($request->get('brand_id'));
                $user->brands()->attach($brand);
                $user->update(['selected_brand_id' => $brand->id]);
            }

            // Attach all brands to Admin
            if($user->is_superadmin)
                $user->brands()->attach(Brand::all());

            return response()->success("User updated successfully.", User::with(['role', 'brands'])->find($user->id));
        }

        return response()->error("Something going wrong! Please try again or contact the support..");
    }

    /**
     * Reset exists user password
     *
     * @param \App\User $user
     * @param \App\Http\Requests\ResetUserPasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(User $user, ResetUserPasswordRequest $request)
    {
        abort_if(Gate::denies('update', $user), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Get data
        $data = $request->validated();

        // Update user row
        $updated = $user->update($data);

        if($updated)
            return response()->success("User password reseted successfully.", User::with(['role', 'brands'])->find($user->id));

        return response()->error("Something going wrong! Please try again or contact the support..");
    }

    /**
     * Ban/UnBan user
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function ban(User $user)
    {
        // Check ability
        abort_if(Gate::denies('ban', $user), Response::HTTP_FORBIDDEN, "403 Forbidden");

        $updated = $user->update([
            'banned'    =>  !$user->banned
        ]);
        $user = $user->refresh();

        if($updated)
            return response()->success("User {$user->name} " . ($user->banned ? "banned" : "unbanned") . " successfully.", User::with(['role', 'brands'])->find($user->id));


        return response()->error("Something going wrong! Please try again or contact the support..");
    }
    
    /**
     * Change active brand
     *
     * @param \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function changeActiveBrand(Brand $brand)
    {
        // Check ability
        // abort_if(Gate::denies('ban', $user), Response::HTTP_FORBIDDEN, "403 Forbidden");

        $user = Auth::user();
        $updated = $user->update([
            'selected_brand_id' => $brand->id
        ]);

        if($updated)
            return response()->success("User {$user->name} selected brand changed successfully.", User::with(['selectedBrand'])->find($user->id));

        return response()->error("Something going wrong! Please try again or contact the support..");
    }

    /**
     * List users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('viewAny', Auth::user()), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return response()->success("Users fetched successfully.", User::with(['selectedBrand', 'brands', 'role'])->get());
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

        return response()->success("User fetched successfully.", User::with(['brands', 'selectedBrand', 'role'])->find($user->id));
    }

    /**
     * Delete user
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {
        abort_if(Gate::denies('delete', $user), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Delete user row
        $user->delete();

        return response()->success("User deleted successfully.", [], 204);
    }
}
