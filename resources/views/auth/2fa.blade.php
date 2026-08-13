@extends('layouts.app')

@section('title', 'Two-Factor Authentication')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4 col-lg-3">
        <div class="card auth-card p-4">
            <h3 class="text-center mb-3"><i class="bi bi-shield-check me-2"></i>2FA Verification</h3>
            <p class="text-center text-muted">Enter the 6-digit code from your authenticator app.</p>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('2fa.verify') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Authentication Code</label>
                    <input type="text" name="code" class="form-control text-center fs-4" placeholder="000000" maxlength="6" required autofocus style="letter-spacing: 8px;">
                </div>
                <button class="btn btn-success w-100">
                    <i class="bi bi-check-circle me-1"></i> Verify
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
