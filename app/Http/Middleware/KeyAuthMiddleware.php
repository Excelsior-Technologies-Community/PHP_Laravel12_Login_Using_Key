<?php

namespace App\Http\Middleware;

use App\Models\KeyAuth;
use App\Models\KeyAuthSession;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KeyAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('keyauth_user')) {
            return redirect()->route('login.form')->with('error', 'Please login to access this page.');
        }

        $user = KeyAuth::find(Session::get('keyauth_user'));

        if (!$user) {
            Session::forget('keyauth_user');
            return redirect()->route('login.form')->with('error', 'User not found. Please login again.');
        }

        if (!$user->hasVerifiedEmail()) {
            Session::forget('keyauth_user');
            return redirect()->route('login.form')->with('error', 'Please verify your email before accessing the dashboard.');
        }

        if ($user->hasConfirmedTwoFactor() && !$request->session()->has('2fa_passed')) {
            return redirect()->route('2fa.form');
        }

        return $next($request);
    }
}
