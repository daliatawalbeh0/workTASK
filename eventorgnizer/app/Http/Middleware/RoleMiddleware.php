<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if user has the required role
        if (Auth::user() && Auth::user()->role == $role) {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }
}
