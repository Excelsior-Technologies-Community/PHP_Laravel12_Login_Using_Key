# PHP_Laravel12_Login_Using_Key

# Step 1: Install Laravel 12 Create Project 
Run command 
```php
Composer create –project laravel/laravel your folder name “^12.0”
```
# Step 2: Setup Database for .env file 
```php
 DB_CONNECTION=mysql
 DB_HOST=127.0.0.1
 DB_PORT=3306
 DB_DATABASE=your database name 
 DB_USERNAME=root
 DB_PASSWORD=
```
# Create Simple Authentication for using key generate and  key login Followed all steps:
# Step 3: Create Migration File For Table Create 
```php
php artisan make:migration create_keyauth_table
```
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keyauth', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('login_key');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keyauth');
    }
};
```
# Now Run Migration
```php
php artisan migrate
```
# Step 4: Create Model
```php
php artisan make:model KeyAuth
```
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyAuth extends Model
{
    use HasFactory;

    protected $table = 'keyauth';

    protected $fillable = [
        'name',
        'email',
        'login_key',
    ];
}

```

# Step 5: Create Controller for store register and login and logout method
```php
php artisan make:controller KeyAuthController
```
```php
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

```

# Step 6: Create Routes for web.php file
```php
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
```
# Step 7: Create Register and Login Blade file in resource/view/auth folder
# resource/view/auth/register.blade.php
```php
@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card auth-card p-4">
            <h3 class="text-center mb-3"> Register</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

           <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Create Login Key (4 digit or custom)</label>
        <input type="text" name="login_key" class="form-control" minlength="4" maxlength="4" required>
    </div>

    <button class="btn btn-primary w-100">Register</button>
</form>


            <div class="text-center mt-3">
                Already registered?
                <a href="{{ route('login.form') }}">Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
```
# resource/view/auth/login.blade.php
```php
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card auth-card p-4">
            <h3 class="text-center mb-3">Login</h3>

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR --}}
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- ONLY LOGIN KEY --}}
                <div class="mb-3">
                    <label class="form-label">Login Key</label>
                    <input
                        type="password"
                        name="key"
                        class="form-control"
                        placeholder="Enter your login key"
                        required
                    >
                </div>

                <button class="btn btn-success w-100">
                    Login
                </button>
            </form>

            <div class="text-center mt-3">
                New user?
                <a href="{{ route('register.form') }}">Register here</a>
            </div>
        </div>
    </div>
</div>
@endsection

```
# resource/view/dashboard.blade.php
```php
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card auth-card p-4">

            <h3 class="mb-3">Welcome, {{ $user->name }}</h3>

            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">Name</th>
                    <td>{{ $user->name }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>

                <tr>
                    <th>Login Key</th>
                    <td>
                        <span class="badge bg-dark fs-6">
                            {{ $user->login_key }}
                        </span>
                    </td>
                </tr>
            </table>

            <div class="text-end mt-3">
                <a href="{{ route('logout') }}" class="btn btn-danger">
                    Logout
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

```
# Now Run Project and paste this url
```php
Php artisan serve
```
```php
http://127.0.0.1:8000/register
```
<img width="1614" height="649" alt="image" src="https://github.com/user-attachments/assets/3a20d582-5301-4a70-89d8-ed1ce47e6cb4" />
<img width="1645" height="529" alt="image" src="https://github.com/user-attachments/assets/780ca348-a8bd-4870-a5f0-ba9da7b3bfcf" />

<img width="1580" height="480" alt="image" src="https://github.com/user-attachments/assets/94773890-213e-448a-bfac-7e02428f6f48" />

 
 

