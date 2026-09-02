<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register - Key Auth</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 16px;

            padding: 35px;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.20);
        }

        .logo {
            width: 70px;
            height: 70px;

            margin: 0 auto 15px;

            border-radius: 50%;

            background: linear-gradient(
                135deg,
                #667eea,
                #764ba2
            );

            color: #ffffff;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 30px;
        }

        h1 {
            text-align: center;

            color: #222222;

            margin-bottom: 8px;

            font-size: 28px;
        }

        .subtitle {
            text-align: center;

            color: #777777;

            margin-bottom: 28px;

            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            margin-bottom: 8px;

            font-size: 14px;

            font-weight: 600;

            color: #333333;
        }

        .required {
            color: #dc3545;
        }

        input {
            width: 100%;

            padding: 13px 14px;

            border: 1px solid #dddddd;

            border-radius: 8px;

            font-size: 15px;

            outline: none;

            transition: 0.2s;
        }

        input:focus {
            border-color: #667eea;

            box-shadow:
                0 0 0 3px rgba(102, 126, 234, 0.12);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 60px;
        }

        .toggle-password {
            position: absolute;

            right: 12px;
            top: 50%;

            transform: translateY(-50%);

            border: none;

            background: transparent;

            cursor: pointer;

            color: #667eea;

            font-size: 13px;

            font-weight: 600;
        }

        .toggle-password:hover {
            color: #4f5fd3;
        }

        .error {
            color: #dc3545;

            font-size: 13px;

            margin-top: 6px;
        }

        .alert {
            padding: 12px 14px;

            border-radius: 8px;

            margin-bottom: 20px;

            font-size: 14px;
        }

        .alert-success {
            background: #e8f8ee;

            color: #187a3d;

            border: 1px solid #bce8ca;
        }

        .alert-error {
            background: #fdeaea;

            color: #b42318;

            border: 1px solid #f5c2c0;
        }

        .alert-error ul {
            margin: 8px 0 0 18px;
        }

        .alert-error li {
            margin-bottom: 4px;
        }

        .info-box {
            background: #f4f6ff;

            border: 1px solid #dfe3ff;

            color: #4a55a2;

            padding: 12px 14px;

            border-radius: 8px;

            font-size: 13px;

            margin-bottom: 20px;

            line-height: 1.5;
        }

        .password-info {
            display: block;

            margin-top: 6px;

            color: #777777;

            font-size: 12px;
        }

        .btn {
            width: 100%;

            border: none;

            padding: 14px;

            border-radius: 8px;

            background: linear-gradient(
                135deg,
                #667eea,
                #764ba2
            );

            color: #ffffff;

            font-size: 16px;

            font-weight: 600;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn:hover {
            opacity: 0.92;

            transform: translateY(-1px);

            box-shadow:
                0 8px 20px rgba(102, 126, 234, 0.30);
        }

        .bottom-text {
            text-align: center;

            margin-top: 22px;

            color: #777777;

            font-size: 14px;
        }

        .bottom-text a {
            color: #667eea;

            text-decoration: none;

            font-weight: 600;
        }

        .bottom-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {

            .auth-card {
                padding: 25px 20px;
            }

            h1 {
                font-size: 24px;
            }

        }

    </style>

</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        {{-- Logo --}}
        <div class="logo">
            🔑
        </div>


        {{-- Heading --}}
        <h1>
            Create Account
        </h1>

        <p class="subtitle">
            Register your secure Key Auth account
        </p>


        {{-- Success Message --}}
        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        {{-- Error Message --}}
        @if(session('error'))

            <div class="alert alert-error">
                {{ session('error') }}
            </div>

        @endif


        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="alert alert-error">

                <strong>
                    Please fix the following:
                </strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Security Information --}}
        <div class="info-box">

            🔐 Your login key is securely protected.

            <br>

            Please remember your login key because you will use it
            to log in.

        </div>


        {{-- Register Form --}}
        <form
            method="POST"
            action="{{ route('register') }}"
        >

            @csrf


            {{-- =========================
                 NAME
            ========================== --}}
            <div class="form-group">

                <label for="name">

                    Full Name

                    <span class="required">*</span>

                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter your full name"
                    autocomplete="name"
                    required
                >

                @error('name')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- =========================
                 EMAIL
            ========================== --}}
            <div class="form-group">

                <label for="email">

                    Email Address

                    <span class="required">*</span>

                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email address"
                    autocomplete="email"
                    required
                >

                @error('email')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- =========================
                 LOGIN KEY
            ========================== --}}
            <div class="form-group">

                <label for="login_key">

                    Login Key

                    <span class="required">*</span>

                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="login_key"
                        name="login_key"
                        placeholder="Create your login key"
                        minlength="6"
                        autocomplete="new-password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword(
                            'login_key',
                            this
                        )"
                    >
                        Show
                    </button>

                </div>

                @error('login_key')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- =========================
                 CONFIRM LOGIN KEY
            ========================== --}}
            <div class="form-group">

                <label for="login_key_confirmation">

                    Confirm Login Key

                    <span class="required">*</span>

                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="login_key_confirmation"
                        name="login_key_confirmation"
                        placeholder="Confirm your login key"
                        minlength="6"
                        autocomplete="new-password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword(
                            'login_key_confirmation',
                            this
                        )"
                    >
                        Show
                    </button>

                </div>

                @error('login_key_confirmation')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- =========================
                 PASSWORD
            ========================== --}}
            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="new-password"
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword(
                            'password',
                            this
                        )"
                    >
                        Show
                    </button>

                </div>

                <span class="password-info">

                    Password is optional.
                    You can use your login key to authenticate.

                </span>

                @error('password')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- =========================
                 CONFIRM PASSWORD
            ========================== --}}
            <div class="form-group">

                <label for="password_confirmation">

                    Confirm Password

                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                        autocomplete="new-password"
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword(
                            'password_confirmation',
                            this
                        )"
                    >
                        Show
                    </button>

                </div>

                @error('password_confirmation')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- =========================
                 SUBMIT
            ========================== --}}
            <button
                type="submit"
                class="btn"
            >
                Create Account
            </button>

        </form>


        {{-- Login Link --}}
        <div class="bottom-text">

            Already have an account?

            <a href="{{ route('login.form') }}">
                Login here
            </a>

        </div>

    </div>

</div>


<script>

    function togglePassword(inputId, button) {

        const input = document.getElementById(inputId);

        if (!input) {
            return;
        }

        if (input.type === 'password') {

            input.type = 'text';

            button.textContent = 'Hide';

        } else {

            input.type = 'password';

            button.textContent = 'Show';

        }

    }

</script>

</body>

</html>

