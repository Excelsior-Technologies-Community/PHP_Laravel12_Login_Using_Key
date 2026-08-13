@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card auth-card p-4">
            <h3 class="text-center mb-3"><i class="bi bi-person-plus me-2"></i>Register</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    <div class="form-text">We will send a verification link to this email.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Login Key</label>
                    <input type="text" name="login_key" class="form-control" minlength="4" maxlength="255" value="{{ old('login_key') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password (Optional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Create a password for dual login">
                    <div class="form-text">Leave empty to use key-only login.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm your password">
                </div>

                <button class="btn btn-primary w-100">
                    <i class="bi bi-person-plus me-1"></i> Create Account
                </button>
            </form>

            <div class="text-center mt-3">
                Already registered? <a href="{{ route('login.form') }}">Login here</a>
            </div>
        </div>
    </div>
</div>
@endsection
