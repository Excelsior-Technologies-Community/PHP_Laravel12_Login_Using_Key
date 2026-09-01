<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeyAuthController;

Route::get('/', function () {

    if (session()->has('keyauth_user')) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login.form');

});


/*
|--------------------------------------------------------------------------
| Registration
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


/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get(
    '/login',
    [KeyAuthController::class, 'loginForm']
)->name('login.form');

Route::post(
    '/login',
    [KeyAuthController::class, 'login']
)
    ->middleware('throttle:5,1')
    ->name('login');


/*
|--------------------------------------------------------------------------
| Two Factor Authentication
|--------------------------------------------------------------------------
*/

Route::get(
    '/2fa',
    [KeyAuthController::class, 'twoFactorForm']
)->name('2fa.form');

Route::post(
    '/2fa/verify',
    [KeyAuthController::class, 'verify2fa']
)->name('2fa.verify');


/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/

Route::get(
    '/email/verify/{id}/{hash}',
    [KeyAuthController::class, 'verifyEmail']
)
    ->name('verification.verify')
    ->middleware('signed');

Route::post(
    '/email/verification-notification',
    [KeyAuthController::class, 'resendVerification']
)->name('verification.resend');


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
)->name('forgot.key.send');

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

Route::middleware(['keyauth'])->group(function () {

    /*
    | Dashboard
    */

    Route::get(
        '/dashboard',
        [KeyAuthController::class, 'dashboard']
    )->name('dashboard');


    /*
    | Profile
    */

    Route::get(
        '/profile',
        [KeyAuthController::class, 'profileForm']
    )->name('profile.form');

    Route::post(
        '/profile',
        [KeyAuthController::class, 'updateProfile']
    )->name('profile.update');


    /*
    | Security
    */

    Route::get(
        '/profile/security',
        [KeyAuthController::class, 'securityForm']
    )->name('profile.security');


    /*
    | 2FA
    */

    Route::post(
        '/profile/security/2fa',
        [KeyAuthController::class, 'toggleTwoFactor']
    )->name('2fa.toggle');

    Route::get(
        '/profile/security/2fa/setup',
        [KeyAuthController::class, 'twoFactorSetup']
    )->name('2fa.setup');

    Route::post(
        '/profile/security/2fa/confirm',
        [KeyAuthController::class, 'confirmTwoFactorSetup']
    )->name('2fa.confirm');


    /*
    | Password
    */

    Route::post(
        '/profile/password',
        [KeyAuthController::class, 'updatePassword']
    )->name('password.update');


    /*
    | Sessions
    */

    Route::get(
        '/profile/sessions',
        [KeyAuthController::class, 'sessionsList']
    )->name('profile.sessions');


    /*
    | Users
    */

    Route::get(
        '/users',
        [KeyAuthController::class, 'usersList']
    )->name('users.index');


    /*
    | Logout All
    */

    Route::post(
        '/logout-all',
        [KeyAuthController::class, 'logoutAllDevices']
    )->name('logout.all');

});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::get(
    '/logout',
    [KeyAuthController::class, 'logout']
)->name('logout');


/*
|--------------------------------------------------------------------------
| Get Login Key
|--------------------------------------------------------------------------
*/

Route::get(
    '/get-login-key',
    [KeyAuthController::class, 'getLoginKey']
)->name('get.login.key');