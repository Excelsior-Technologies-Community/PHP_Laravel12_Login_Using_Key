<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KeyAuthController;
use App\Http\Middleware\KeyAuthMiddleware;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    function () {
        return redirect()->route('login.form');
    }
);


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get(
    '/register',
    [KeyAuthController::class, 'registerForm']
)->name('register.form');

Route::post(
    '/register',
    [KeyAuthController::class, 'register']
)->name('register');


Route::get(
    '/login',
    [KeyAuthController::class, 'loginForm']
)->name('login.form');

Route::post(
    '/login',
    [KeyAuthController::class, 'login']
)->name('login');


/*
|--------------------------------------------------------------------------
| Generate Login Key
|--------------------------------------------------------------------------
*/

Route::get(
    '/generate-login-key',
    [KeyAuthController::class, 'generateLoginKey']
)->name('login-key.generate');


/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/

Route::get(
    '/verify-email/{id}/{hash}',
    [KeyAuthController::class, 'verifyEmail']
)->name('verification.verify');


/*
|--------------------------------------------------------------------------
| Forgot / Reset Login Key
|--------------------------------------------------------------------------
*/

Route::get(
    '/forgot-key',
    [KeyAuthController::class, 'forgotKeyForm']
)->name('forgot.key.form');

Route::post(
    '/forgot-key',
    [KeyAuthController::class, 'sendResetKeyLink']
)->name('forgot.key');

Route::get(
    '/reset-key/{token}',
    [KeyAuthController::class, 'resetKeyForm']
)->name('reset.key.form');

Route::post(
    '/reset-key',
    [KeyAuthController::class, 'resetKey']
)->name('reset.key');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    KeyAuthMiddleware::class
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [KeyAuthController::class, 'dashboard']
    )->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/logout',
        [KeyAuthController::class, 'logout']
    )->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Logout All Devices
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/logout-all-devices',
        [KeyAuthController::class, 'logoutAllDevices']
    )->name('logout.all.devices');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [KeyAuthController::class, 'profileForm']
    )->name('profile.edit');

    Route::put(
        '/profile',
        [KeyAuthController::class, 'updateProfile']
    )->name('profile.update');


    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/security',
        [KeyAuthController::class, 'securityForm']
    )->name('profile.security');

    Route::post(
        '/security/2fa',
        [KeyAuthController::class, 'toggleTwoFactor']
    )->name('2fa.toggle');


    /*
    |--------------------------------------------------------------------------
    | 2FA Setup
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/2fa/setup',
        [KeyAuthController::class, 'twoFactorSetup']
    )->name('2fa.setup');

    Route::post(
        '/2fa/setup',
        [KeyAuthController::class, 'confirmTwoFactorSetup']
    )->name('2fa.setup.confirm');


    /*
    |--------------------------------------------------------------------------
    | 2FA Login
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/2fa',
        [KeyAuthController::class, 'twoFactorForm']
    )->name('2fa.form');

    Route::post(
        '/2fa',
        [KeyAuthController::class, 'verify2fa']
    )->name('2fa.verify');


    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    */

    Route::put(
        '/password',
        [KeyAuthController::class, 'updatePassword']
    )->name('password.update');


    /*
    |--------------------------------------------------------------------------
    | Sessions
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/sessions',
        [KeyAuthController::class, 'sessionsList']
    )->name('sessions.index');


    /*
    |--------------------------------------------------------------------------
    | USER MANAGEMENT
    |--------------------------------------------------------------------------
    |
    | Feature 3: Search
    | Feature 4: Sorting
    | Feature 5: Pagination
    | Feature 6: Delete
    |
    */

    Route::get(
        '/users',
        [KeyAuthController::class, 'usersList']
    )->name('users.index');

    Route::delete(
        '/users/{id}',
        [KeyAuthController::class, 'deleteUser']
    )->name('users.delete');

});