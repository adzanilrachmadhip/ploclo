<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class JwtAuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $data['username'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $payload = [
            'iss' => url('/'),
            'sub' => $user->id_user,
            'role' => $user->role,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 8),
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET', 'change-me'), 'HS256');

        return response()->json([
            'access_token' => $jwt,
            'token_type'   => 'bearer',
            'expires_in'   => 60 * 60 * 8,
            'user' => [
                'id_user'     => $user->id_user,
                'username'    => $user->username,
                'nama_lengkap'=> $user->nama_lengkap,
                'role'        => $user->role,
            ],
        ]);
    }

    public function me()
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        return response()->json(['user' => $user]);
    }

    public function logout()
    {
        return response()->json(['message' => 'Logged out']);
    }
}
