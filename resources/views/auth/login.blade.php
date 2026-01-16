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
