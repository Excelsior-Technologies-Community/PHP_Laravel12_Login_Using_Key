<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Key Auth System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg-body: #f1f3f5;
            --bg-card: #ffffff;
            --bg-navbar: #1a1d21;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --input-bg: #ffffff;
            --table-stripe: #f8f9fa;
            --table-hover: #f1f3f5;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        [data-theme="dark"] {
            --bg-body: #0f1115;
            --bg-card: #1a1d24;
            --bg-navbar: #0d0f12;
            --text-primary: #e9ecef;
            --text-secondary: #adb5bd;
            --text-muted: #8d99ae;
            --border-color: #2d3238;
            --input-bg: #23262b;
            --table-stripe: #1e2128;
            --table-hover: #25282e;
            --shadow: 0 4px 20px rgba(0,0,0,0.35);
        }

        html, body {
            background: var(--bg-body) !important;
            color: var(--text-primary);
        }

        body {
            transition: background 0.3s ease, color 0.3s ease;
            min-height: 100vh;
        }

        /* ---------- CARDS ---------- */
        .auth-card, .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            box-shadow: var(--shadow);
            transition: background 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .auth-card {
            border-radius: 14px;
        }

        /* ---------- NAVBAR ---------- */
        .navbar {
            background: var(--bg-navbar) !important;
            border-bottom: 1px solid var(--border-color);
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            letter-spacing: 0.4px;
        }
        .navbar .nav-link {
            color: rgba(255,255,255,0.85) !important;
            transition: color 0.2s;
        }
        .navbar .nav-link:hover {
            color: #ffffff !important;
        }
        .navbar .btn-outline-light {
            border-color: rgba(255,255,255,0.45);
            color: #fff;
        }
        .navbar .navbar-toggler {
            border-color: rgba(255,255,255,0.35);
        }
        .navbar .navbar-toggler-icon {
            filter: invert(1);
        }

        /* ---------- TEXT ---------- */
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            color: var(--text-primary);
        }
        p, span, div, td, th, label, li, a {
            color: var(--text-primary);
        }
        .text-muted, .text-secondary, small, .form-text {
            color: var(--text-secondary) !important;
        }

        /* ---------- LINKS ---------- */
        a {
            color: #4dabf7;
            text-decoration: none;
        }
        a:hover {
            color: #339af0;
        }

        /* ---------- TABLES ---------- */
        .table {
            color: var(--text-primary);
            border-color: var(--border-color);
        }
        .table thead th {
            background: var(--table-stripe);
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
        }
        .table tbody td {
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        .table-striped > tbody > tr:nth-of-type(odd) > * {
            background-color: var(--table-stripe);
            color: var(--text-primary);
        }
        .table-hover > tbody > tr:hover > * {
            background-color: var(--table-hover);
            color: var(--text-primary);
        }
        [data-theme="dark"] .table-success {
            --bs-table-bg: #1e3a2f;
            --bs-table-color: #b2f2bb;
        }
        [data-theme="light"] .table-success {
            --bs-table-bg: #d1e7dd;
            --bs-table-color: #0f5132;
        }

        /* ---------- FORMS ---------- */
        .form-control, .form-select, .form-check-input {
            background: var(--input-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }
        .form-control:focus, .form-select:focus {
            background: var(--input-bg);
            color: var(--text-primary);
            border-color: #4dabf7;
            box-shadow: 0 0 0 3px rgba(77, 171, 247, 0.15);
        }
        .form-control::placeholder {
            color: var(--text-muted);
            opacity: 0.7;
        }
        .input-group-text {
            background: var(--table-stripe);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }
        .form-check-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
        }
        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236c757d' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        }

        /* ---------- ALERTS ---------- */
        .alert {
            border: none;
            color: var(--text-primary);
        }
        [data-theme="dark"] .alert-success {
            background: #1e3a2f;
            color: #b2f2bb;
        }
        [data-theme="dark"] .alert-danger {
            background: #3a1f1f;
            color: #f1aeb5;
        }
        [data-theme="dark"] .alert-warning {
            background: #3d3419;
            color: #fde293;
        }
        [data-theme="dark"] .alert-info {
            background: #112d3f;
            color: #a5d8ff;
        }
        [data-theme="light"] .alert-success {
            background: #d1e7dd;
            color: #0f5132;
        }
        [data-theme="light"] .alert-danger {
            background: #f8d7da;
            color: #842029;
        }
        [data-theme="light"] .alert-warning {
            background: #fff3cd;
            color: #664d03;
        }
        [data-theme="light"] .alert-info {
            background: #cff4fc;
            color: #055160;
        }

        /* ---------- BADGES ---------- */
        .badge {
            color: #fff;
        }
        .bg-dark, .badge.bg-dark {
            background: #495057 !important;
        }
        .bg-secondary, .badge.bg-secondary {
            background: var(--badge-bg) !important;
        }
        [data-theme="dark"] .badge.bg-secondary {
            background: #495057 !important;
        }

        /* ---------- BUTTONS ---------- */
        .btn-outline-secondary {
            color: var(--text-primary);
            border-color: var(--border-color);
        }
        .btn-outline-secondary:hover {
            color: var(--text-primary);
            background: var(--table-stripe);
        }
        .btn-outline-danger {
            color: #f1aeb5;
            border-color: #f1aeb5;
        }
        .btn-outline-danger:hover {
            color: #fff;
            background: #dc3545;
            border-color: #dc3545;
        }
        [data-theme="light"] .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }
        [data-theme="light"] .btn-outline-danger:hover {
            color: #fff;
            background: #dc3545;
        }

        /* ---------- TABS ---------- */
        .nav-tabs {
            border-bottom-color: var(--border-color);
        }
        .nav-tabs .nav-link {
            color: var(--text-secondary);
            border: none;
            border-bottom: 2px solid transparent;
            border-radius: 0;
        }
        .nav-tabs .nav-link.active {
            color: #198754 !important;
            border-bottom-color: #198754;
            background: transparent !important;
        }
        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: var(--text-primary);
        }

        /* ---------- MODAL ---------- */
        .modal-content {
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }
        .modal-header, .modal-footer {
            border-color: var(--border-color);
        }
        .btn-close {
            filter: invert(1);
        }

        /* ---------- DROPDOWN ---------- */
        .dropdown-menu {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        .dropdown-item {
            color: var(--text-primary);
        }
        .dropdown-item:hover, .dropdown-item:focus {
            background: var(--table-hover);
            color: var(--text-primary);
        }

        /* ---------- PAGINATION ---------- */
        .pagination {
            --bs-pagination-bg: var(--bg-card);
            --bs-pagination-color: var(--text-primary);
            --bs-pagination-border-color: var(--border-color);
        }
        .page-item.active .page-link {
            background: #198754;
            border-color: #198754;
        }
        .page-link {
            background: var(--bg-card);
            color: var(--text-primary);
            border-color: var(--border-color);
        }
        .page-link:hover {
            background: var(--table-hover);
            color: var(--text-primary);
        }

        /* ---------- STATS ---------- */
        .stat-card {
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }

        /* ---------- LOGIN TABS ---------- */
        .login-tabs .nav-link {
            color: var(--text-secondary) !important;
            border: none;
            border-bottom: 2px solid transparent;
            border-radius: 0;
        }
        .login-tabs .nav-link.active {
            color: #198754 !important;
            border-bottom-color: #198754;
            background: transparent !important;
        }

        /* ---------- TOGGLE ICON ---------- */
        #themeToggle {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            padding: 0;
        }

        /* ---------- MISC ---------- */
        .border-dashed {
            border-style: dashed !important;
        }
        .text-primary-custom {
            color: var(--text-primary) !important;
        }

        /* ---------- BREADCRUMBS ---------- */
        .breadcrumb {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
        }
        .breadcrumb-item a {
            color: #4dabf7;
        }
        .breadcrumb-item.active {
            color: var(--text-secondary);
        }

        /* ---------- LIST GROUP ---------- */
        .list-group-item {
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }
        .list-group-item:hover {
            background: var(--table-hover);
            color: var(--text-primary);
        }

        /* ---------- CLOSE BUTTON ---------- */
        .btn-close {
            filter: invert(0.5);
        }
        [data-theme="dark"] .btn-close {
            filter: invert(1);
        }

        /* ---------- PLACEHOLDER ---------- */
        ::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.7;
        }

        /* ---------- HR / DIVIDER ---------- */
        hr {
            border-color: var(--border-color);
            opacity: 1;
        }

        /* ---------- PROGRESS BAR ---------- */
        .progress {
            background: var(--table-stripe);
        }

        /* ---------- TOOLTIP ---------- */
        .tooltip-inner {
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        /* ---------- POPOVER ---------- */
        .popover {
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }
        .popover-header {
            background: var(--table-stripe);
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-color);
        }

        /* ---------- ACCORDION ---------- */
        .accordion-item {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        .accordion-button {
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }
        .accordion-button:not(.collapsed) {
            background: var(--table-stripe);
            color: var(--text-primary);
        }
        .accordion-button::after {
            filter: invert(0.5);
        }
        [data-theme="dark"] .accordion-button::after {
            filter: invert(1);
        }

        /* ---------- OFFcanvas ---------- */
        .offcanvas {
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }
        .offcanvas-header {
            border-bottom: 1px solid var(--border-color);
        }

        /* ---------- BADGE TEXT COLORS ---------- */
        .text-bg-dark {
            background: #495057 !important;
            color: #fff !important;
        }

        /* ---------- FORM RANGE ---------- */
        input[type="range"] {
            accent-color: #198754;
        }

        /* ---------- SWITCH / TOGGLE ---------- */
        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }

        /* ---------- CODE / PRE ---------- */
        code, pre {
            background: var(--table-stripe);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        /* ---------- BLOCKQUOTE ---------- */
        blockquote {
            border-left: 4px solid var(--border-color);
            color: var(--text-secondary);
        }

        /* ---------- FIGURE / FIGURE CAPTION ---------- */
        figure {
            color: var(--text-primary);
        }
        figcaption {
            color: var(--text-secondary);
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 576px) {
            .navbar-nav .nav-link {
                padding: 0.5rem 0;
            }
            .btn-sm {
                margin-top: 0.5rem;
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="bi bi-shield-lock me-2"></i>Key Auth System
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                @if(session()->has('keyauth_user'))
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.form') }}" class="nav-link">Profile</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-sm btn-outline-light ms-lg-2 mt-2 mt-lg-0" id="themeToggle">
                            <i class="bi bi-moon"></i>
                        </button>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="btn btn-sm btn-danger ms-lg-2 mt-2 mt-lg-0">Logout</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login.form') }}" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register.form') }}" class="btn btn-sm btn-success ms-lg-2">Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

{{-- MAIN CONTENT --}}
<div class="container py-4 py-md-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    if (themeToggle) {
        themeToggle.innerHTML = savedTheme === 'dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
        themeToggle.addEventListener('click', () => {
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            themeToggle.innerHTML = next === 'dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
        });
    }
</script>
</body>
</html>
