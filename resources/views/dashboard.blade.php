@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ============================================================
     DASHBOARD HEADER
============================================================ --}}

<div class="row mb-4">

    <div class="col-12">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>

                <h2 class="mb-1">
                    Welcome, {{ $user->name }}
                </h2>

                <p class="text-muted mb-0">
                    Here's what's happening with your account.
                </p>

            </div>

            <div>

                <span class="badge bg-success px-3 py-2">

                    <i class="bi bi-shield-check me-1"></i>

                    Account Secure

                </span>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
     STATISTICS
============================================================ --}}

<div class="row g-3 mb-4">

    {{-- TOTAL USERS --}}

    <div class="col-md-3">

        <div class="card stat-card p-3 h-100">

            <div class="d-flex align-items-center">

                <div class="bg-primary bg-gradient text-white rounded p-3 me-3">

                    <i class="bi bi-people"></i>

                </div>

                <div>

                    <div class="text-muted small">
                        Total Users
                    </div>

                    <div class="fw-bold fs-4">
                        {{ $stats['total_users'] }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- VERIFIED USERS --}}

    <div class="col-md-3">

        <div class="card stat-card p-3 h-100">

            <div class="d-flex align-items-center">

                <div class="bg-success bg-gradient text-white rounded p-3 me-3">

                    <i class="bi bi-check-circle"></i>

                </div>

                <div>

                    <div class="text-muted small">
                        Verified Users
                    </div>

                    <div class="fw-bold fs-4">
                        {{ $stats['verified_users'] }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TODAY LOGINS --}}

    <div class="col-md-3">

        <div class="card stat-card p-3 h-100">

            <div class="d-flex align-items-center">

                <div class="bg-info bg-gradient text-white rounded p-3 me-3">

                    <i class="bi bi-box-arrow-in-right"></i>

                </div>

                <div>

                    <div class="text-muted small">
                        Today's Logins
                    </div>

                    <div class="fw-bold fs-4">
                        {{ $stats['today_logins'] }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- FAILED LOGINS TODAY --}}

    <div class="col-md-3">

        <div class="card stat-card p-3 h-100">

            <div class="d-flex align-items-center">

                <div class="bg-danger bg-gradient text-white rounded p-3 me-3">

                    <i class="bi bi-x-circle"></i>

                </div>

                <div>

                    <div class="text-muted small">
                        Failed Logins Today
                    </div>

                    <div class="fw-bold fs-4 text-danger">
                        {{ $stats['failed_logins_today'] }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
     LOGIN KEY SECURITY
============================================================ --}}

<div class="card auth-card p-4 mb-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

        <div>

            <h5 class="mb-1">

                <i class="bi bi-key-fill me-2"></i>

                Login Key Security

            </h5>

            <p class="text-muted small mb-0">

                Your account uses email + login key authentication.

            </p>

        </div>

        <span class="badge bg-success px-3 py-2">

            <i class="bi bi-shield-check me-1"></i>

            Login Key Enabled

        </span>

    </div>


    <div class="row g-3">

        {{-- LOGIN KEY STATUS --}}

        <div class="col-md-4">

            <div class="border rounded p-3 h-100">

                <div class="text-muted small mb-2">

                    <i class="bi bi-key me-1"></i>

                    Authentication Method

                </div>

                <div class="fw-bold">

                    Email + Login Key

                </div>

                <div class="small text-success mt-2">

                    <i class="bi bi-check-circle me-1"></i>

                    Active

                </div>

            </div>

        </div>


        {{-- LAST LOGIN --}}

        <div class="col-md-4">

            <div class="border rounded p-3 h-100">

                <div class="text-muted small mb-2">

                    <i class="bi bi-clock-history me-1"></i>

                    Last Successful Login

                </div>

                @if($securitySummary['last_login'])

                    <div class="fw-bold">

                        {{ $securitySummary['last_login']->login_at->format('M d, Y') }}

                    </div>

                    <div class="small text-muted">

                        {{ $securitySummary['last_login']->login_at->format('h:i A') }}

                    </div>

                    <div class="small text-success mt-2">

                        {{ $securitySummary['last_login']->login_at->diffForHumans() }}

                    </div>

                @else

                    <div class="text-muted">
                        No login history
                    </div>

                @endif

            </div>

        </div>


        {{-- FAILED ATTEMPTS --}}

        <div class="col-md-4">

            <div class="border rounded p-3 h-100">

                <div class="text-muted small mb-2">

                    <i class="bi bi-shield-exclamation me-1"></i>

                    Failed Attempts

                </div>

                <div class="fw-bold text-danger">

                    {{ $securitySummary['total_failed_logins'] }}

                </div>

                <div class="small text-muted mt-2">

                    {{ $securitySummary['failed_last_7_days'] }}

                    failed in the last 7 days

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
     LOGIN SECURITY
============================================================ --}}

<div class="card auth-card p-4 mb-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

        <div>

            <h5 class="mb-1">

                <i class="bi bi-shield-lock me-2"></i>

                Login Security

            </h5>

            <p class="text-muted small mb-0">

                Monitor your recent login activity and account security.

            </p>

        </div>

        <a
            href="{{ route('profile.sessions') }}"
            class="btn btn-sm btn-outline-primary"
        >

            <i class="bi bi-display me-1"></i>

            View Sessions

        </a>

    </div>


    <div class="row g-3">

        {{-- LAST LOGIN --}}

        <div class="col-md-6 col-lg-3">

            <div class="border rounded p-3 h-100">

                <div class="text-muted small mb-2">

                    <i class="bi bi-clock-history me-1"></i>

                    Last Successful Login

                </div>

                @if($securitySummary['last_login'])

                    <div class="fw-bold">

                        {{ $securitySummary['last_login']->login_at->format('M d, Y') }}

                    </div>

                    <div class="small text-muted">

                        {{ $securitySummary['last_login']->login_at->format('h:i A') }}

                    </div>

                    <div class="small text-success mt-2">

                        {{ $securitySummary['last_login']->login_at->diffForHumans() }}

                    </div>

                @else

                    <div class="text-muted">
                        No login history
                    </div>

                @endif

            </div>

        </div>


        {{-- IP --}}

        <div class="col-md-6 col-lg-3">

            <div class="border rounded p-3 h-100">

                <div class="text-muted small mb-2">

                    <i class="bi bi-globe me-1"></i>

                    Last Login IP

                </div>

                @if($securitySummary['last_login'])

                    <div class="fw-bold text-break">

                        {{ $securitySummary['last_login']->ip_address ?? 'Unknown' }}

                    </div>

                    <div class="small text-muted mt-2">

                        {{ $securitySummary['last_login']->platform ?? 'Unknown Platform' }}

                    </div>

                @else

                    <div class="text-muted">
                        Unknown
                    </div>

                @endif

            </div>

        </div>


        {{-- DEVICE --}}

        <div class="col-md-6 col-lg-3">

            <div class="border rounded p-3 h-100">

                <div class="text-muted small mb-2">

                    <i class="bi bi-laptop me-1"></i>

                    Last Login Device

                </div>

                @if($securitySummary['last_login'])

                    <div class="fw-bold">

                        {{ $securitySummary['last_login']->device_type ?? 'Unknown' }}

                    </div>

                    <div class="small text-muted mt-2">

                        Browser:
                        {{ $securitySummary['last_login']->browser ?? 'Unknown' }}

                    </div>

                @else

                    <div class="text-muted">
                        Unknown
                    </div>

                @endif

            </div>

        </div>


        {{-- LOGIN COUNTS --}}

        <div class="col-md-6 col-lg-3">

            <div class="border rounded p-3 h-100">

                <div class="text-muted small mb-2">

                    <i class="bi bi-bar-chart me-1"></i>

                    Login Attempts

                </div>

                <div class="fw-bold">

                    {{ $securitySummary['total_successful_logins'] }}

                    successful

                </div>

                <div class="small text-danger mt-1">

                    {{ $securitySummary['total_failed_logins'] }}

                    failed

                </div>

                <div class="small text-muted mt-1">

                    {{ $securitySummary['failed_last_7_days'] }}

                    failed in last 7 days

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
     SECURITY WARNING
============================================================ --}}

@if($recentFailedLogins->count() > 0)

    <div class="alert alert-warning alert-dismissible fade show mb-4">

        <div class="d-flex">

            <div class="me-3 fs-4">

                <i class="bi bi-exclamation-triangle"></i>

            </div>

            <div>

                <strong>
                    Recent failed login attempts detected
                </strong>

                <div class="small mt-1">

                    There have been

                    <strong>
                        {{ $securitySummary['failed_last_7_days'] }}
                    </strong>

                    failed login attempt(s) on your account during the last 7 days.

                </div>

                <a
                    href="#recent-login-history"
                    class="small fw-bold"
                >

                    Review login activity

                </a>

            </div>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif


<div class="row g-3">


    {{-- ========================================================
         LEFT COLUMN
    ========================================================= --}}

    <div class="col-lg-5">


        {{-- RECENT LOGINS --}}

        <div
            class="card auth-card p-3 mb-3"
            id="recent-login-history"
        >

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">

                    <i class="bi bi-clock-history me-2"></i>

                    Recent Login Activity

                </h5>

                <span class="badge bg-primary">

                    {{ $recentLogins->count() }}

                </span>

            </div>


            @if($recentLogins->count() > 0)

                <div class="table-responsive">

                    <table class="table table-sm align-middle">

                        <thead>

                            <tr>

                                <th>Date</th>

                                <th>Device</th>

                                <th>IP</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($recentLogins as $login)

                                <tr>

                                    <td>

                                        <div>

                                            {{ $login->login_at->format('M d') }}

                                        </div>

                                        <small class="text-muted">

                                            {{ $login->login_at->format('H:i') }}

                                        </small>

                                    </td>

                                    <td>

                                        {{ $login->device_type ?? '-' }}

                                    </td>

                                    <td>

                                        <small>

                                            {{ $login->ip_address ?? '-' }}

                                        </small>

                                    </td>

                                    <td>

                                        @if($login->status === 'success')

                                            <span class="badge bg-success">

                                                Success

                                            </span>

                                        @elseif($login->status === 'failed')

                                            <span class="badge bg-danger">

                                                Failed

                                            </span>

                                        @else

                                            <span class="badge bg-warning">

                                                Blocked

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-4">

                    <i class="bi bi-clock-history fs-1 text-muted"></i>

                    <p class="text-muted mt-2 mb-0">

                        No login history yet.

                    </p>

                </div>

            @endif

        </div>


        {{-- ACTIVE SESSIONS --}}

        <div class="card auth-card p-3">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">

                    <i class="bi bi-display me-2"></i>

                    Active Sessions

                </h5>

                <form
                    method="POST"
                    action="{{ route('logout.all') }}"
                    class="d-inline"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Logout from all devices?')"
                    >

                        <i class="bi bi-box-arrow-right me-1"></i>

                        Logout All

                    </button>

                </form>

            </div>


            @if($userSessions->count() > 0)

                <div class="table-responsive">

                    <table class="table table-sm align-middle">

                        <thead>

                            <tr>

                                <th>Device</th>

                                <th>IP</th>

                                <th>Last Active</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($userSessions as $session)

                                <tr class="{{ $session->is_current ? 'table-success' : '' }}">

                                    <td>

                                        <i class="bi bi-{{
                                            $session->device_type == 'mobile'
                                                ? 'phone'
                                                : (
                                                    $session->device_type == 'tablet'
                                                        ? 'tablet'
                                                        : 'laptop'
                                                )
                                        }} me-1"></i>

                                        {{ $session->device_type ?? '-' }}

                                        @if($session->is_current)

                                            <span class="badge bg-success ms-1">

                                                Current

                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        {{ $session->ip_address ?? '-' }}

                                    </td>

                                    <td>

                                        @if($session->last_activity)

                                            {{ $session->last_activity->diffForHumans() }}

                                        @else

                                            -

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <p class="text-muted mb-0">

                    No active sessions.

                </p>

            @endif

        </div>

    </div>


    {{-- ========================================================
         RIGHT COLUMN
    ========================================================= --}}

    <div class="col-lg-7">


        {{-- PROFILE INFORMATION --}}

        <div class="card auth-card p-3 mb-3">

            <h5 class="mb-3">

                <i class="bi bi-person me-2"></i>

                Profile Information

            </h5>


            <div class="d-flex align-items-center mb-3">

                @if($user->profile_pic)

                    <img
                        src="{{ asset('storage/' . $user->profile_pic) }}"
                        class="rounded-circle me-3"
                        width="80"
                        height="80"
                        alt="Profile"
                    >

                @else

                    <div
                        class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                        style="width:80px;height:80px;font-size:2rem;"
                    >

                        {{ strtoupper(substr($user->name, 0, 1)) }}

                    </div>

                @endif


                <div>

                    <div class="fw-bold">

                        {{ $user->name }}

                    </div>

                    <div class="text-muted">

                        {{ $user->email }}

                    </div>


                    @if($user->hasVerifiedEmail())

                        <span class="badge bg-success">

                            <i class="bi bi-check-circle me-1"></i>

                            Verified

                        </span>

                    @else

                        <span class="badge bg-warning">

                            <i class="bi bi-exclamation-circle me-1"></i>

                            Unverified

                        </span>

                    @endif

                </div>

            </div>


            <div class="d-flex gap-2 flex-wrap">

                <a
                    href="{{ route('profile.form') }}"
                    class="btn btn-sm btn-primary"
                >

                    <i class="bi bi-pencil me-1"></i>

                    Edit Profile

                </a>

                <a
                    href="{{ route('profile.security') }}"
                    class="btn btn-sm btn-outline-secondary"
                >

                    <i class="bi bi-shield me-1"></i>

                    Security

                </a>

            </div>

        </div>


        {{-- LAST 7 DAYS ACTIVITY --}}

        <div class="card auth-card p-3 mb-3">

            <h5 class="mb-3">

                <i class="bi bi-bar-chart me-2"></i>

                Your Last 7 Days Activity

            </h5>


            @php

                $chartData = $recentLoginsChart;

                $maxCount = $chartData->max('count') ?: 1;

            @endphp


            <div
                class="d-flex align-items-end gap-2"
                style="height: 200px;"
            >

                @for($i = 6; $i >= 0; $i--)

                    @php

                        $date = now()->subDays($i);

                        $dayData = $chartData->firstWhere(
                            'date',
                            $date->format('Y-m-d')
                        );

                        $count = $dayData
                            ? $dayData->count
                            : 0;

                        $height = ($count / $maxCount) * 100;

                    @endphp


                    <div class="flex-fill text-center">

                        <div
                            class="bg-success mx-auto rounded"
                            style="
                                width: 100%;
                                height: {{ max($height, 2) }}%;
                                max-height: 180px;
                            "
                            title="{{ $count }} successful login(s)"
                        ></div>

                        <div class="small text-muted mt-1">

                            {{ $date->format('D') }}

                        </div>

                        <div class="fw-bold">

                            {{ $count }}

                        </div>

                    </div>

                @endfor

            </div>

        </div>


        {{-- RECENT FAILED ATTEMPTS --}}

        <div class="card auth-card p-3">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">

                    <i class="bi bi-shield-exclamation me-2"></i>

                    Recent Failed Attempts

                </h5>

                @if($recentFailedLogins->count() > 0)

                    <span class="badge bg-danger">

                        {{ $recentFailedLogins->count() }}

                    </span>

                @endif

            </div>


            @if($recentFailedLogins->count() > 0)

                @foreach($recentFailedLogins as $failedLogin)

                    <div class="d-flex align-items-center border-bottom py-3">

                        {{-- ICON --}}

                        <div
                            class="bg-danger bg-opacity-10 text-danger rounded p-2 me-3"
                            style="min-width:45px;text-align:center;"
                        >

                            <i class="bi bi-x-circle fs-5"></i>

                        </div>


                        {{-- DETAILS --}}

                        <div class="flex-grow-1">

                            <div class="fw-semibold text-danger">

                                Failed login attempt

                            </div>

                            <div class="small text-muted">

                                {{ $failedLogin->login_at->format('M d, Y h:i A') }}

                                ·

                                {{ $failedLogin->device_type ?? 'Unknown device' }}

                            </div>

                            <div class="small text-muted">

                                <i class="bi bi-globe me-1"></i>

                                IP:

                                {{ $failedLogin->ip_address ?? 'Unknown' }}

                            </div>

                            <div class="small text-muted">

                                <i class="bi bi-browser-chrome me-1"></i>

                                Browser:

                                {{ $failedLogin->browser ?? 'Unknown' }}

                            </div>

                            @if($failedLogin->attempted_identifier)

                                <div class="small text-muted">

                                    <i class="bi bi-person me-1"></i>

                                    Attempted:

                                    {{ $failedLogin->attempted_identifier }}

                                </div>

                            @endif

                        </div>


                        {{-- STATUS --}}

                        <span class="badge bg-danger">

                            Failed

                        </span>

                    </div>

                @endforeach

            @else

                <div class="text-center py-4">

                    <i class="bi bi-shield-check text-success fs-2"></i>

                    <p class="text-muted mb-0 mt-2">

                        No failed login attempts found.

                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection

