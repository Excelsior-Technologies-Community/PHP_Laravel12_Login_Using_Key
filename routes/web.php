<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeyAuthController;

// Register
Route::get('/register', [KeyAuthController::class, 'registerForm'])->name('register.form');
Route::post('/register', [KeyAuthController::class, 'register'])->name('register');

// Login
Route::get('/login', [KeyAuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [KeyAuthController::class, 'login'])->name('login');

// Dashboard
Route::get('/dashboard', [KeyAuthController::class, 'dashboard'])->name('dashboard');

// Logout
Route::get('/logout', [KeyAuthController::class, 'logout'])->name('logout');

Route::get('/get-login-key', function (\Illuminate\Http\Request $request) {
    $user = \App\Models\KeyAuth::where('email', $request->email)->first();

    if ($user) {
        return response()->json([
            'status' => true,
            'key' => $user->login_key
        ]);
    }

    return response()->json([
        'status' => false
    ]);
})->name('get.login.key');

