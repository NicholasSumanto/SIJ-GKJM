<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user) {
            if ($user->id_role == 1) {
                if (Auth::guard('admin')->attempt($request->only('username', 'password'))) {
                    return redirect()->intended(route('admin.dashboard'));
                }
            } else {
                if (Auth::guard('adminWilayah')->attempt($request->only('username', 'password'))) {
                    return redirect()->intended(route('admin-wilayah.dashboard'));
                }
            }
        } else {
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('adminWilayah')->logout();
        Auth::logout();
        return redirect()->route('landing');
    }
}
