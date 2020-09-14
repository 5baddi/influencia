<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'name' => 'required'
        ]);

        $password = Hash::make(request('password'));

        $user = User::create(request(['name', 'email', 'password', 'role']));

        if (request('brand_id') && request('role') == 'BRAND_OWNER') {
            $user->brands()->attach(request('brand_id'));
            $user->update(["selected_brand_id" => request('brand_id')]);
        }

        if (request('role') == 'SUPER_ADMIN') {
            $user->brands()->attach(Brand::all());
        }

        return response($user->load('brands'), 201);
    }
    public function index(Request $request)
    {
        return User::with('brands')->get();
    }
}
