<?php

namespace App\Http\Controllers;

use App\HelperResponses\ApiResponse;


use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('API-Token')->plainTextToken;
                $data = [
                    'user' =>  new UserResource($user),
                    'token' => $token,
                    'message' => 'Login Berhasil'
                ];
                return ApiResponse::success($data, "Berhasil login", 202);
            }
            return response()->json(['message' => 'Email atau password salah.'], 401);
        } catch (\Exception $e) {
            return ApiResponse::error($e, "Terjadi error server", 500);
        }
    }


    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                $user->tokens()->delete(); // Revoke all tokens belonging to the user
            }
            return ApiResponse::success(new stdClass, "Berhasil logout", 202);
        } catch (\Exception $e) {
            return ApiResponse::error($e, "Terjadi error server gagal logout", 500);
        }
    }
}
