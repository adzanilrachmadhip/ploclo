<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ?string $roles = null)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if (! $roles) {
            return $next($request);
        }

        $allowed = array_map('strtolower', array_map('trim', explode(',', $roles)));

        if (! in_array(strtolower($user->role), $allowed)) {
            return response()->json(['error' => 'Forbidden, insufficient role'], 403);
        }

        return $next($request);
    }
}
