<?php

namespace App\Http\Middleware;

use App\HelperResponses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return ApiResponse::errorWithStatus(null, 'Anda belum login', 401);
        }

        $user = Auth::user();

        if ($user->role != $role) {
            return ApiResponse::errorWithStatus(null, 'Unauthorized.', 403);
        }

        return $next($request);
    }
}
