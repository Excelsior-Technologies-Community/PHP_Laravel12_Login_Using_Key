<?php

namespace App\Http\Controllers;

use App\Models\KeyAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KeyAuthController extends Controller
{
    // 🔹 Register page
    public function registerForm()
    {
        return view('auth.register');
    }

    // 🔹 Save Registration
    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required',
            'email'      => 'required|email|unique:keyauth,email',
            'login_key'  => 'required|min:4|max:4'
        ]);

        KeyAuth::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'login_key' => $request->login_key,
        ]);

        return redirect()->route('login.form')
            ->with('success', 'Registration successful! Use your login key.');
    }

    // 🔹 Login page
    public function loginForm()
    {
        return view('auth.login');
    }

    // 🔹 Login check (ONLY BY KEY)
    public function login(Request $request)
    {
        $request->validate([
            'key' => 'required'
        ]);

        // Find user only by key
        $user = KeyAuth::where('login_key', $request->key)->first();

        if (!$user) {
            return back()->with('error', 'Invalid Login Key!');
        }

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
