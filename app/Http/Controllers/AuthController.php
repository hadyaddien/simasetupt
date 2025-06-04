<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $role = Auth::user()->roles;
            if ($role === 'administrator') {
                return redirect('/admin');
            } elseif ($role === 'viewer') {
                return redirect('/user');
            } elseif ($role === 'approver') {
                return redirect('/approver');
            } elseif ($role === 'validator') {
                return redirect('/validator');
            }
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $roles = auth()->user()->roles;
            if ($roles == 'administrator') {
                return redirect('/admin');
            } else if ($roles == 'viewer') {
                return redirect('/user');
            } else if ($roles == 'approver') {
                return redirect('/approver');
            } else if ($roles == 'validator') {
                return redirect('/validator');
            }
        }

        return back()->withErrors([
            'password' => 'Email or password is incorrect'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
