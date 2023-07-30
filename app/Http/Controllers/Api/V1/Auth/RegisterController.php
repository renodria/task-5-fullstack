<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => ['required', 'max:100', 'alpha'],
            'username' => ['required', 'min:5', 'max:50', 'unique:users'],
            'email' => ['required', 'min:5', 'max:100', 'email:dns', 'unique:users'],
            'password' => ['required', Password::min(5)->mixedCase()->letters()->numbers()->uncompromised(), 'max:255'],
        ]);

        $validation['password'] = Hash::make($validation['password']);
        $user = User::create($validation);

        $token = $user->createToken('Authorization')->accessToken;
  
        return response()->json([
            'message' => 'User created successfully',
            'token' => $token
        ], 200);
    }
}
