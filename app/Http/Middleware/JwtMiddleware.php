<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $auth = $request->header('Authorization');
        if (! $auth || ! preg_match('/Bearer\s+(.*)$/i', $auth, $matches)) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            $decoded = JWT::decode($matches[1], new Key(env('JWT_SECRET', 'change-me'), 'HS256'));

            $user = User::where('id_user', $decoded->sub)->first();
            if (! $user) {
                return response()->json(['error' => 'User not found'], 401);
            }

            Auth::loginUsingId($user->id_user);
            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token', 'message' => $e->getMessage()], 401);
        }
    }
}
