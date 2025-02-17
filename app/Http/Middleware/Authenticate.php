<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null; // Jika request expects JSON, return null
        }
        if (Auth::guard('admin')->check()) {
            return route('admin.dashboard'); // Redirect ke admin dashboard
        }
        if (Auth::guard('adminWilayah')->check()) {
            return route('admin-wilayah.dashboard');
        }

        // Default: redirect ke halaman landing
        return route('landing');
    }
}
