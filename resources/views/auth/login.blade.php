@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="row justify-content-center">


<div class="col-md-5 col-lg-4">

    <div class="card auth-card p-4">

        <h3 class="text-center mb-3">
            <i class="bi bi-shield-lock me-2"></i>
            Login
        </h3>


        {{-- Verification URL --}}
        @if(session('verification_url'))

            <div class="alert alert-success">

                <i class="bi bi-envelope-check me-1"></i>

                <strong>Verify your email!</strong>

                <br>

                <a
                    href="{{ session('verification_url') }}"
                    target="_blank"
                >
                    Click here to verify your email
                </a>

            </div>

        @endif


        {{-- Success --}}
        @if(session('success'))

            <div class="alert alert-success">

                <i class="bi bi-check-circle me-1"></i>

                {{ session('success') }}

            </div>

        @endif


        {{-- Error --}}
        @if(session('error'))

            <div class="alert alert-danger">

                <i class="bi bi-exclamation-triangle me-1"></i>

                {{ session('error') }}

            </div>

        @endif


        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =================================================
             LOGIN TABS
        ================================================== --}}

        <ul
            class="nav nav-tabs login-tabs mb-3"
            id="loginTab"
            role="tablist"
        >

            {{-- LOGIN KEY --}}
            <li
                class="nav-item"
                role="presentation"
            >

                <button
                    class="nav-link active"
                    id="key-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#key-panel"
                    type="button"
                    role="tab"
                >

                    <i class="bi bi-key me-1"></i>

                    Login Key

                </button>

            </li>


            {{-- EMAIL + LOGIN KEY --}}
            <li
                class="nav-item"
                role="presentation"
            >

                <button
                    class="nav-link"
                    id="email-key-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#email-key-panel"
                    type="button"
                    role="tab"
                >

                    <i class="bi bi-envelope-key me-1"></i>

                    Email + Login Key

                </button>

            </li>

        </ul>


        <div
            class="tab-content"
            id="loginTabContent"
        >


            {{-- =================================================
                 LOGIN KEY ONLY
            ================================================== --}}

            <div
                class="tab-pane fade show active"
                id="key-panel"
                role="tabpanel"
            >

                <form
                    method="POST"
                    action="{{ route('login') }}"
                >

                    @csrf


                    <div class="mb-3">

                        <label class="form-label">

                            <i class="bi bi-key me-1"></i>

                            Login Key

                        </label>

                        <input
                            type="password"
                            name="key"
                            class="form-control"
                            placeholder="Enter your login key"
                            required
                            autofocus
                        >

                    </div>


                    <div class="mb-3 form-check">

                        <input
                            type="checkbox"
                            name="remember"
                            class="form-check-input"
                            id="rememberKey"
                        >

                        <label
                            class="form-check-label"
                            for="rememberKey"
                        >
                            Remember Me
                        </label>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-success w-100"
                    >

                        <i class="bi bi-box-arrow-in-right me-1"></i>

                        Login with Key

                    </button>

                </form>

            </div>


            {{-- =================================================
                 EMAIL + LOGIN KEY
            ================================================== --}}

            <div
                class="tab-pane fade"
                id="email-key-panel"
                role="tabpanel"
            >

                <form
                    method="POST"
                    action="{{ route('login') }}"
                >

                    @csrf


                    {{-- EMAIL --}}
                    <div class="mb-3">

                        <label class="form-label">

                            <i class="bi bi-envelope me-1"></i>

                            Email

                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control"
                            placeholder="Enter your email"
                            required
                        >

                    </div>


                    {{-- LOGIN KEY --}}
                    <div class="mb-3">

                        <label class="form-label">

                            <i class="bi bi-key me-1"></i>

                            Login Key

                        </label>

                        <input
                            type="password"
                            name="key"
                            class="form-control"
                            placeholder="Enter your login key"
                            required
                        >

                    </div>


                    {{-- REMEMBER --}}
                    <div class="mb-3 form-check">

                        <input
                            type="checkbox"
                            name="remember"
                            class="form-check-input"
                            id="rememberEmailKey"
                        >

                        <label
                            class="form-check-label"
                            for="rememberEmailKey"
                        >
                            Remember Me
                        </label>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >

                        <i class="bi bi-box-arrow-in-right me-1"></i>

                        Login with Email + Key

                    </button>

                </form>

            </div>

        </div>


        {{-- LINKS --}}
        <div class="text-center mt-3">

            <a href="{{ route('forgot.key.form') }}">
                Forgot Login Key?
            </a>

            <span class="mx-2">|</span>

            New user?

            <a href="{{ route('register.form') }}">
                Register here
            </a>

        </div>

    </div>

</div>

</div>

@endsection
