<?php

namespace App\Http\Controllers;

use App\Models\KeyAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KeyAuthController extends Controller
{
    // 🔹 Register form
    public function registerForm()
    {
        return view('auth.register');
    }

    // 🔹 Register save
    public function register(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:keyauth,email',
        ]);

        // 🔑 ONE TIME KEY (6 digit)
        $key = rand(100000, 999999);

        KeyAuth::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'login_key' => $key,
        ]);

        return redirect()->route('login.form')
            ->with('success', 'Registration successful. Your login key is: ' . $key);
    }

    // 🔹 Login form
    public function loginForm()
    {
        return view('auth.login');
    }

    // 🔹 Login check
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'key'   => 'required',
        ]);

        $user = KeyAuth::where('email', $request->email)
            ->where('login_key', $request->key)
            ->first();

        if (!$user) {
            return back()->with('error', 'Invalid Email or Key');
        }

        // session set
        Session::put('keyauth_user', $user->id);

        return redirect()->route('dashboard');
    }

    // 🔹 Dashboard
    public function dashboard()
    {
        if (!Session::has('keyauth_user')) {
            return redirect()->route('login.form');
        }

        $user = KeyAuth::find(Session::get('keyauth_user'));

        return view('dashboard', compact('user'));
    }

    // 🔹 Logout
    public function logout()
    {
        Session::forget('keyauth_user');
        return redirect()->route('login.form');
    }
}