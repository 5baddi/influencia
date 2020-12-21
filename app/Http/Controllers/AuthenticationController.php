<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    /**
     * Sign in
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate sign in form
        $data = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        // Load user
        $user = User::with(['selectedBrand', 'brands'])->where('email', $request->email)->first();

        // Verify credentials
        if(!$user || !Hash::check($request->password, $user->password))
            return response()->error("These credentials do not match our records.", [], 404);

        // Generate new token
        $token = $user->createToken('influencia')->plainTextToken;
        // Update last login
        $user->update([
            'last_login' => now()
        ]);

        return response()->success("User sign in successfully.", [
            'user'  => $user,
            'token' => $token
        ]);
    }

    /**
     * Logout user
     * 
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        // Get authenticated user
        $user = Auth::user();

        // Clear tokens 
        if($user)
            $user->tokens()->delete();

        return response()->success("User signed out.");
    }
}
