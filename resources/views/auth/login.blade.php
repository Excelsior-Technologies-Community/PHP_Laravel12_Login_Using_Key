<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - Key Auth</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;

            background: linear-gradient(
                135deg,
                #667eea,
                #764ba2
            );

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 430px;
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

        input[type="email"],
        input[type="password"],
        input[type="text"] {
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

        .remember-row {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 20px;
        }

        .remember {
            display: flex;

            align-items: center;

            gap: 8px;

            margin: 0;

            font-weight: normal;

            cursor: pointer;
        }

        .remember input {
            width: auto;
        }

        .forgot-link {
            color: #667eea;

            text-decoration: none;

            font-size: 13px;

            font-weight: 600;
        }

        .forgot-link:hover {
            text-decoration: underline;
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

        .verification-box {
            background: #fff8e1;

            border: 1px solid #ffe08a;

            color: #7a5a00;

            padding: 12px 14px;

            border-radius: 8px;

            font-size: 13px;

            margin-bottom: 20px;

            line-height: 1.5;
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

        .security-info {
            margin-top: 22px;

            padding-top: 18px;

            border-top: 1px solid #eeeeee;

            text-align: center;

            color: #888888;

            font-size: 12px;

            line-height: 1.5;
        }

        @media (max-width: 500px) {

            .auth-card {
                padding: 25px 20px;
            }

            h1 {
                font-size: 24px;
            }

            .remember-row {
                flex-direction: column;

                align-items: flex-start;

                gap: 10px;
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
            Welcome Back
        </h1>

        <p class="subtitle">
            Login using your secure login key
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
                    Login failed:
                </strong>

                <ul style="margin: 8px 0 0 18px;">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Email Verification --}}
        @if(session('verification_required'))

            <div class="verification-box">

                📧 Please verify your email address
                before logging in.

            </div>

        @endif


        {{-- Login Form --}}
        <form
            method="POST"
            action="{{ route('login') }}"
        >

            @csrf


            {{-- =========================
                 EMAIL
            ========================== --}}
            <div class="form-group">

                <label for="email">

                    Email Address

                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email address"
                    autocomplete="email"
                    required
                    autofocus
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

                <label for="key">

                    Login Key

                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="key"
                        name="key"
                        placeholder="Enter your login key"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword(
                            'key',
                            this
                        )"
                    >
                        Show
                    </button>

                </div>

                @error('key')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- =========================
                 REMEMBER ME + FORGOT KEY
            ========================== --}}
            <div class="remember-row">

                <label class="remember">

                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    Remember me

                </label>


                <a
                    href="{{ route('forgot.key.form') }}"
                    class="forgot-link"
                >
                    Forgot Login Key?
                </a>

            </div>


            {{-- =========================
                 LOGIN BUTTON
            ========================== --}}
            <button
                type="submit"
                class="btn"
            >
                Login
            </button>

        </form>


        {{-- Register Link --}}
        <div class="bottom-text">

            Don't have an account?

            <a href="{{ route('register.form') }}">
                Create Account
            </a>

        </div>


        {{-- Security Information --}}
        <div class="security-info">

            🔒 Your login key is securely protected
            using HMAC hashing.

            <br>

            Never share your login key with anyone.

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
