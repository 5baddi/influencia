<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRequest $request)
    {
        // Get data
        $data = $request->all();

        // Hash the password
        $data['password'] = Hash::make($data['password']);

        // Set user role
        $data['role'] = $request->input('role', 'BRAND_OWNER');

        // Create user row
        $user = User::create($data);

        if($request->get('brand_id') && $data['role'] == 'BRAND_OWNER'){
            // Attach brand 
            $brand = Brand::find($request->get('brand_id'));
            $user->brands()->attach($brand);
            $user->update(['selected_brand_id' => $brand->id]);
        }

        // Attach all brands to Admin
        if($data['role'] == 'SUPER_ADMIN')
            $user->brands()->attach(Brand::all());

        return response()->success("User created successfully.", $user->load('brands'), 201);
    }

    public function index()
    {
        return response()->success("Users fetched successfully.", User::with('brands')->get());
    }

    public function show(User $user)
    {
        return response()->success("User fetched successfully.", $user->load('brands'));
    }

    public function destroy(User $user)
    {
        // Delete user row
        $user->delete();

        return response()->success("User deleted successfully.", [], 204);
    }
}
