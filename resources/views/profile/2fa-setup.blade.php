@extends('layouts.app')

@section('title', 'Setup Two-Factor Authentication')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card auth-card p-4">
            <h3 class="mb-3"><i class="bi bi-shield-check me-2"></i>Setup Two-Factor Authentication</h3>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                </div>
            @endif

            <div class="alert alert-info">
                <i class="bi bi-info-circle me-1"></i>
                <strong>Step 1:</strong> Scan the QR code below with your authenticator app (Google Authenticator, Authy, etc.) or manually enter the secret key.
            </div>

            <div class="text-center my-4">
                @if($qrCodeSvg)
                    <div class="d-inline-block p-3 bg-white rounded shadow-sm">
                        <img src="{{ $qrCodeSvg }}" alt="QR Code" style="width: 200px; height: 200px;">
                    </div>
                @else
                    <div class="alert alert-warning">
                        QR code generation failed. Please use the manual entry method below.
                    </div>
                @endif
            </div>

            <div class="alert alert-warning">
                <strong>Manual Entry Key:</strong><br>
                <code class="fs-5">{{ $secret }}</code>
            </div>

            <div class="alert alert-info">
                <strong>Step 2:</strong> Enter the 6-digit code from your authenticator app to verify and enable 2FA.
            </div>

            <form method="POST" action="{{ route('2fa.confirm') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Verification Code</label>
                    <input type="text" name="code" class="form-control text-center fs-4" placeholder="000000" maxlength="6" required autofocus style="letter-spacing: 8px;">
                </div>
                <button class="btn btn-success w-100">
                    <i class="bi bi-check-circle me-1"></i> Verify & Enable 2FA
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('profile.security') }}"><i class="bi bi-arrow-left me-1"></i>Back to Security</a>
            </div>
        </div>
    </div>
</div>
@endsection
