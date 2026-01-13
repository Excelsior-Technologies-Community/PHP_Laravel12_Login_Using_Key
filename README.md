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
                    <input type="text" name="name" class="form-control" placeholder="Enter name">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email">
                </div>

                <button class="btn btn-primary w-100">
                    Register & Generate Key
                </button>
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
            <h3 class="text-center mb-3"> Login</h3>

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

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="Enter email"
                        required
                    >
                </div>

                {{-- LOGIN KEY (HIDDEN LIKE PASSWORD) --}}
                <div class="mb-3">
                    <label class="form-label">Login Key</label>
                    <input
                        type="password"
                        name="key"
                        id="login_key"
                        class="form-control"
                       
                        readonly
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

{{-- 🔥 AUTO LOAD KEY (BUT NOT VISIBLE) --}}
<script>
document.getElementById('email').addEventListener('blur', function () {
    let email = this.value.trim();
    let keyField = document.getElementById('login_key');

    if (email === '') {
        keyField.value = '';
        return;
    }

    fetch(`/get-login-key?email=${email}`)
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                keyField.value = data.key; // auto fill but hidden
            } else {
                keyField.value = '';
                alert('Email not registered');
            }
        });
});
</script>
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
            <h3 class="mb-3"> Welcome, {{ $user->name }}</h3>

            <table class="table table-bordered">
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Your Login Key</th>
                    <td>
                        <span class="badge bg-dark fs-6">
                            {{ $user->login_key }}
                        </span>
                    </td>
                </tr>
            </table>

            <div class="text-end">
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
 <img width="1610" height="553" alt="image" src="https://github.com/user-attachments/assets/5bed81d8-13d8-433d-919c-317cdc7fd595" />
<img width="1603" height="646" alt="image" src="https://github.com/user-attachments/assets/cb820b06-8ef3-4b34-9b8b-58703e6570e3" />
<img width="1635" height="422" alt="image" src="https://github.com/user-attachments/assets/53f6ef96-8e89-41cc-a47f-c1edf9fd3b89" />

 
 

