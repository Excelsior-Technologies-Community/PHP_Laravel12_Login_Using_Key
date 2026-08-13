@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card auth-card p-4">
            <h3 class="text-center mb-3"><i class="bi bi-shield-lock me-2"></i>Login</h3>

            @if(session('verification_url'))
                <div class="alert alert-success">
                    <i class="bi bi-envelope-check me-1"></i> <strong>Verify your email!</strong><br>
                    <a href="{{ session('verification_url') }}" target="_blank">Click here to verify your email</a>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                </div>
            @endif

            <ul class="nav nav-tabs login-tabs mb-3" id="loginTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="key-tab" data-bs-toggle="tab" data-bs-target="#key-panel" type="button">Login Key</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-panel" type="button">Email & Password</button>
                </li>
            </ul>

            <div class="tab-content" id="loginTabContent">
                <div class="tab-pane fade show active" id="key-panel" role="tabpanel">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Login Key</label>
                            <input type="password" name="key" class="form-control" placeholder="Enter your login key" required autofocus>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="rememberKey">
                            <label class="form-check-label" for="rememberKey">Remember Me</label>
                        </div>
                        <button class="btn btn-success w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login with Key
                        </button>
                    </form>
                </div>

                <div class="tab-pane fade" id="password-panel" role="tabpanel">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email or Login Key</label>
                            <input type="text" name="key" class="form-control" placeholder="Enter your email or login key" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="rememberPass">
                            <label class="form-check-label" for="rememberPass">Remember Me</label>
                        </div>
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login with Password
                        </button>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('forgot.key.form') }}">Forgot Login Key?</a>
                <span class="mx-2">|</span>
                New user? <a href="{{ route('register.form') }}">Register here</a>
            </div>
        </div>
    </div>
</div>
@endsection
