@extends('layouts.app')

@section('title', 'Security Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card auth-card p-4">
            <h3 class="mb-3"><i class="bi bi-shield-lock me-2"></i>Security Settings</h3>

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

            <form method="POST" action="{{ route('2fa.toggle') }}">
                @csrf
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="fw-bold">Two-Factor Authentication</div>
                        <div class="text-muted small">Add an extra layer of security</div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="two_factor_enabled" id="twoFactorSwitch" {{ $user->hasConfirmedTwoFactor() ? 'checked' : '' }}>
                    </div>
                </div>
                @if($user->hasConfirmedTwoFactor())
                    <p class="text-success small"><i class="bi bi-check-circle me-1"></i>2FA is enabled</p>
                @else
                    <p class="text-muted small"><i class="bi bi-info-circle me-1"></i>2FA is disabled</p>
                @endif
                <button class="btn btn-sm btn-outline-primary w-100">Save 2FA Setting</button>
            </form>

            <hr>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
