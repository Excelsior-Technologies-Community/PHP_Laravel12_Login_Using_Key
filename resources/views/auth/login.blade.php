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