<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = $request->validate([
            'email' => ['required', 'min:5', 'max:100', 'email:dns'],
            'password' => ['required', Password::min(5)->mixedCase()->letters()->numbers()->uncompromised(), 'max:255'],
        ]);
  
        if (auth()->attempt($user)) 
        {
            $token = auth()->user()->createToken('authorization')->accessToken;
            
            return response()->json([
                'message' => 'User login successfully',
                'token' => $token
            ], 200);
        } 
        
        if (!auth()->attempt($user)) 
        {
            return response()->json([
                'error' => 'Unauthorised',
                'message' => 'Login error, please register!'
            ], 401);
        }
    }
}
