<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Key Auth System')</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .auth-card {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>

{{-- 🔹 NAVBAR --}}
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
             PHP Laravel Key Auth
        </a>

        <div>
            @if(session()->has('keyauth_user'))
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-light">Dashboard</a>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-danger ms-2">Logout</a>
            @else
                <a href="{{ route('login.form') }}" class="btn btn-sm btn-outline-light">Login</a>
                <a href="{{ route('register.form') }}" class="btn btn-sm btn-success ms-2">Register</a>
            @endif
        </div>
    </div>
</nav>

{{-- 🔹 MAIN CONTENT --}}
<div class="container py-5">
    @yield('content')
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
