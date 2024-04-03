<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API-Token')->plainTextToken;

            return response()->json([
                'data' => new UserResource($user),
                'token' => $token,
                'message' => 'Login berhasil'
            ]);
        }

        return response()->json(['message' => 'Email atau password salah.'], 401);
    }
}
