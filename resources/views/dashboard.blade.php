<!DOCTYPE html>

<html lang="en">

<head>

    ```
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Key Auth System')
    </title>

    {{-- Bootstrap --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    {{-- Bootstrap Icons --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">


    <style>
        :root {
            --primary-color: #0d6efd;
            --bg-color: #f5f7fb;
            --card-bg: #ffffff;
            --text-color: #212529;
            --muted-color: #6c757d;
        }


        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;
            padding: 0;
            background: var(--bg-color);
            color: var(--text-color);
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Arial,
                sans-serif;
            min-height: 100vh;
        }


        /* ======================================================
       NAVBAR
    ====================================================== */

        .main-navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
        }


        .navbar-brand {
            font-weight: 700;
        }


        .navbar .nav-link {
            transition: 0.2s ease;
        }


        .navbar .nav-link:hover {
            opacity: 0.8;
        }


        /* ======================================================
       MAIN CONTENT
    ====================================================== */

        main {
            min-height: calc(100vh - 70px);
        }


        .page-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }


        /* ======================================================
       CARDS
    ====================================================== */

        .auth-card,
        .main-card,
        .stat-card {
            background: var(--card-bg);
            border: 0;
            border-radius: 14px;
            box-shadow:
                0 4px 20px rgba(0, 0, 0, 0.06);
        }


        .auth-card {
            transition: transform 0.2s ease,
                box-shadow 0.2s ease;
        }


        .auth-card:hover {
            box-shadow:
                0 6px 25px rgba(0, 0, 0, 0.08);
        }


        /* ======================================================
       BUTTONS
    ====================================================== */

        .btn {
            border-radius: 8px;
        }


        /* ======================================================
       FORMS
    ====================================================== */

        .form-control,
        .form-select {
            border-radius: 8px;
        }


        .form-control:focus,
        .form-select:focus {
            box-shadow:
                0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }


        /* ======================================================
       TABLE
    ====================================================== */

        .table {
            margin-bottom: 0;
        }


        .table th {
            white-space: nowrap;
        }


        .table td {
            vertical-align: middle;
        }


        /* ======================================================
       BADGES
    ====================================================== */

        .badge {
            border-radius: 6px;
        }


        /* ======================================================
       ALERTS
    ====================================================== */

        .alert {
            border-radius: 10px;
        }


        /* ======================================================
       FOOTER
    ====================================================== */

        .main-footer {
            padding: 20px;
            text-align: center;
            color: var(--muted-color);
            font-size: 14px;
        }


        /* ======================================================
       DARK MODE
    ====================================================== */

        body.dark-mode {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --text-color: #f1f1f1;
            --muted-color: #adb5bd;

            background: #121212;
            color: #f1f1f1;
        }


        body.dark-mode .card,
        body.dark-mode .auth-card,
        body.dark-mode .main-card,
        body.dark-mode .stat-card {
            background: #1e1e1e;
            color: #f1f1f1;
        }


        body.dark-mode .table {
            --bs-table-bg: #1e1e1e;
            --bs-table-color: #f1f1f1;
            --bs-table-border-color: #343a40;
        }


        body.dark-mode .table-light {
            --bs-table-bg: #2a2a2a;
            --bs-table-color: #f1f1f1;
        }


        body.dark-mode .text-muted {
            color: #adb5bd !important;
        }


        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background: #2a2a2a;
            color: #fff;
            border-color: #495057;
        }


        body.dark-mode .form-control::placeholder {
            color: #adb5bd;
        }


        body.dark-mode .border {
            border-color: #495057 !important;
        }


        body.dark-mode .bg-light {
            background: #2a2a2a !important;
        }


        /* ======================================================
       RESPONSIVE
    ====================================================== */

        @media (max-width: 768px) {

            .page-container {
                padding: 20px 12px;
            }


            .navbar .btn {
                width: 100%;
            }


            .table-responsive {
                font-size: 14px;
            }

        }
    </style>

    @stack('styles')
    ```

</head>

<body>

    {{-- ============================================================
NAVBAR
============================================================ --}}

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark main-navbar">

        ```
        <div class="container-fluid px-3 px-lg-4">


            {{-- BRAND --}}

            <a
                class="navbar-brand"
                href="{{ session()->has('keyauth_user') ? route('dashboard') : route('login.form') }}">

                <i class="bi bi-shield-lock-fill me-2"></i>

                Key Auth System

            </a>


            {{-- MOBILE BUTTON --}}

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>


            {{-- NAVIGATION --}}

            <div
                class="collapse navbar-collapse"
                id="mainNavbar">

                <ul class="navbar-nav ms-auto align-items-lg-center">


                    @if(session()->has('keyauth_user'))

                    {{-- ==================================================
                     DASHBOARD
                =================================================== --}}

                    <li class="nav-item">

                        <a
                            href="{{ route('dashboard') }}"
                            class="nav-link">

                            <i class="bi bi-speedometer2 me-1"></i>

                            Dashboard

                        </a>

                    </li>


                    {{-- ==================================================
                     PROFILE
                =================================================== --}}

                    <li class="nav-item">

                        <a
                            href="{{ route('profile.edit') }}"
                            class="nav-link">

                            <i class="bi bi-person me-1"></i>

                            Profile

                        </a>

                    </li>


                    {{-- ==================================================
                     SECURITY
                =================================================== --}}

                    <li class="nav-item">

                        <a
                            href="{{ route('profile.security') }}"
                            class="nav-link">

                            <i class="bi bi-shield-lock me-1"></i>

                            Security

                        </a>

                    </li>


                    {{-- ==================================================
                     SESSIONS
                =================================================== --}}

                    <li class="nav-item">

                        <a
                            href="{{ route('sessions.index') }}"
                            class="nav-link">

                            <i class="bi bi-display me-1"></i>

                            Sessions

                        </a>

                    </li>


                    {{-- ==================================================
                     USERS
                =================================================== --}}

                    <li class="nav-item">

                        <a
                            href="{{ route('users.index') }}"
                            class="nav-link">

                            <i class="bi bi-people me-1"></i>

                            Users

                        </a>

                    </li>


                    {{-- ==================================================
                     THEME BUTTON
                =================================================== --}}

                    <li class="nav-item">

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-light ms-lg-2 mt-2 mt-lg-0"
                            id="themeToggle"
                            title="Toggle dark mode">

                            <i class="bi bi-moon"></i>

                        </button>

                    </li>


                    {{-- ==================================================
                     LOGOUT
                =================================================== --}}

                    <li class="nav-item">

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                            class="d-inline">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-sm btn-danger ms-lg-2 mt-2 mt-lg-0">

                                <i class="bi bi-box-arrow-right me-1"></i>

                                Logout

                            </button>

                        </form>

                    </li>


                    @else

                    {{-- ==================================================
                     LOGIN
                =================================================== --}}

                    <li class="nav-item">

                        <a
                            href="{{ route('login.form') }}"
                            class="nav-link">

                            <i class="bi bi-box-arrow-in-right me-1"></i>

                            Login

                        </a>

                    </li>


                    {{-- ==================================================
                     REGISTER
                =================================================== --}}

                    <li class="nav-item">

                        <a
                            href="{{ route('register.form') }}"
                            class="nav-link">

                            <i class="bi bi-person-plus me-1"></i>

                            Register

                        </a>

                    </li>

                    @endif

                </ul>

            </div>

        </div>
        ```

    </nav>

    {{-- ============================================================
FLASH MESSAGES
============================================================ --}}

    @if(session('success'))

    ```
    <div class="container-fluid px-3 px-lg-4 pt-3">

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    </div>
    ```

    @endif

    @if(session('error'))

    ```
    <div class="container-fluid px-3 px-lg-4 pt-3">

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert">

            <i class="bi bi-exclamation-triangle me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    </div>
    ```

    @endif

    {{-- ============================================================
VALIDATION ERRORS
============================================================ --}}

    @if($errors->any())

    ```
    <div class="container-fluid px-3 px-lg-4 pt-3">

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert">

            <strong>

                <i class="bi bi-exclamation-triangle me-2"></i>

                Please fix the following errors:

            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

                @endforeach

            </ul>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    </div>
    ```

    @endif

    {{-- ============================================================
PAGE CONTENT
============================================================ --}}

    <main>

        ```
        <div class="page-container">

            @yield('content')

        </div>
        ```

    </main>

    {{-- ============================================================
FOOTER
============================================================ --}}

    <footer class="main-footer">

        ```
        <div>

            &copy; {{ date('Y') }}

            Key Auth System.

            All rights reserved.

        </div>
        ```

    </footer>

    {{-- ============================================================
BOOTSTRAP JS
============================================================ --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    {{-- ============================================================
DARK MODE
============================================================ --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const themeToggle =
                document.getElementById('themeToggle');

            const body =
                document.body;


            /*
            |--------------------------------------------------------------------------
            | Load Saved Theme
            |--------------------------------------------------------------------------
            */

            const savedTheme =
                localStorage.getItem('keyauth-theme');


            if (savedTheme === 'dark') {

                body.classList.add('dark-mode');

                if (themeToggle) {

                    themeToggle.innerHTML =
                        '<i class="bi bi-sun"></i>';

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Toggle Theme
            |--------------------------------------------------------------------------
            */

            if (themeToggle) {

                themeToggle.addEventListener('click', function() {

                    body.classList.toggle('dark-mode');


                    if (body.classList.contains('dark-mode')) {

                        localStorage.setItem(
                            'keyauth-theme',
                            'dark'
                        );


                        themeToggle.innerHTML =
                            '<i class="bi bi-sun"></i>';

                    } else {

                        localStorage.setItem(
                            'keyauth-theme',
                            'light'
                        );


                        themeToggle.innerHTML =
                            '<i class="bi bi-moon"></i>';

                    }

                });

            }

        });
    </script>

    @stack('scripts')

</body>

</html>