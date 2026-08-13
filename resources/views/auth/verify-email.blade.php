@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card auth-card p-4 text-center">
            <i class="bi bi-envelope-check display-4 text-success mb-3"></i>
            <h3>Verify Your Email</h3>
            <p class="text-muted">A verification link has been sent to your email address. Please check your inbox and click the link to verify your account.</p>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.resend') }}" class="mt-3">
                @csrf
                <button class="btn btn-outline-primary">
                    <i class="bi bi-envelope me-1"></i> Resend Verification Email
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
