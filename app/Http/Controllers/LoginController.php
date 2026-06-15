<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login_nw');
    }

    public function handleLogin(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($validated)) {
        $request->session()->regenerate();

        $user = Auth::user();
        $role = strtolower(trim($user->role));

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'kaprodi') {
            return redirect()->route('dashboard');
        }

        // if (in_array($role, ['dosen wali', 'dosen_wali', 'dosenwali', 'dosen-wali'])) {
        //     return redirect()->route('dashboard');
        // }

        return redirect()->route('dashboard');
    }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'User and Password Not Match');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
