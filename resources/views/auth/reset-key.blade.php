@extends('layouts.app')

@section('title', 'Reset Login Key')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card auth-card p-4">
            <h3 class="text-center mb-3"><i class="bi bi-key me-2"></i>Reset Login Key</h3>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('reset.key') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $user->email }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label">New Login Key</label>
                    <input type="text" name="login_key" class="form-control" minlength="4" maxlength="255" required>
                </div>

                <button class="btn btn-success w-100">
                    <i class="bi bi-check-circle me-1"></i> Reset Key
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
