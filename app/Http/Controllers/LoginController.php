<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'user' => Auth::user(),
            ]);
        }

        return response()->json([
            'error' => 'Invalid user or password.'
        ], 401);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logout succesfully.'
        ]);
    }
}
