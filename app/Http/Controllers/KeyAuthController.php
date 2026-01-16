<?php

namespace App\Http\Controllers;

use App\Models\KeyAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class KeyAuthController extends Controller
{
    // 🔹 Register page
    public function registerForm()
    {
        return view('auth.register');
    }

    // 🔹 Save Registration (HASH LOGIN KEY)
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:keyauth,email',
            'login_key' => 'required|min:4|max:4'
        ]);

        KeyAuth::create([
            'name'      => $request->name,
            'email'     => $request->email,
            // 🔐 HASHED SAVE (CASE-SENSITIVE)
            'login_key' => Hash::make($request->login_key),
        ]);

        return redirect()->route('login.form')
            ->with('success', 'Registration successful! Use your login key.');
    }

    // 🔹 Login page
    public function loginForm()
    {
        return view('auth.login');
    }

    // 🔹 Login check (ONLY BY KEY, CASE-SENSITIVE)
    public function login(Request $request)
    {
        $request->validate([
            'key' => 'required'
        ]);

        // 🔎 Get all users
        $users = KeyAuth::all();

        foreach ($users as $user) {

            // 🔍 CHECK 1: If stored key is BCRYPT then use Hash::check()
            if (str_starts_with($user->login_key, '$2y$')) {

                if (Hash::check($request->key, $user->login_key)) {
                    Session::put('keyauth_user', $user->id);
                    return redirect()->route('dashboard');
                }

            } else {
                // 🔍 CHECK 2: If old plain key exists (one time migration)
                if ($request->key === $user->login_key) {

                    // 🔐 Auto convert old key into bcrypt for future logins
                    $user->login_key = Hash::make($user->login_key);
                    $user->save();

                    Session::put('keyauth_user', $user->id);
                    return redirect()->route('dashboard');
                }
            }
        }

        return back()->with('error', 'Invalid Login Key!');
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
