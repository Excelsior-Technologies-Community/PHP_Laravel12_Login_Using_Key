@extends('layouts.app')

@section('title', 'Forgot Login Key')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card auth-card p-4">
            <h3 class="text-center mb-3"><i class="bi bi-key me-2"></i>Forgot Login Key?</h3>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('forgot.key.send') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Registered Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">
                    <i class="bi bi-envelope me-1"></i> Send Reset Link
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login.form') }}"><i class="bi bi-arrow-left me-1"></i>Back to Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
