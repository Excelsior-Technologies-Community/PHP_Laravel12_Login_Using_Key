@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-1">Welcome, {{ $user->name }}</h2>
        <p class="text-muted">Here's what's happening with your account.</p>
    </div>
</div>

{{-- STATS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-gradient text-white rounded p-3 me-3">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Users</div>
                    <div class="fw-bold fs-4">{{ $stats['total_users'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success bg-gradient text-white rounded p-3 me-3">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="text-muted small">Verified Users</div>
                    <div class="fw-bold fs-4">{{ $stats['verified_users'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="bg-info bg-gradient text-white rounded p-3 me-3">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <div>
                    <div class="text-muted small">Today's Logins</div>
                    <div class="fw-bold fs-4">{{ $stats['today_logins'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="bg-danger bg-gradient text-white rounded p-3 me-3">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div>
                    <div class="text-muted small">Failed Logins Today</div>
                    <div class="fw-bold fs-4">{{ $stats['failed_logins_today'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        {{-- RECENT LOGINS --}}
        <div class="card auth-card p-3 mb-3">
            <h5 class="mb-3"><i class="bi bi-clock-history me-2"></i>Recent Logins</h5>
            @if($recentLogins->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
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
                                    <td>{{ $login->login_at->format('M d, H:i') }}</td>
                                    <td>{{ $login->device_type ?? '-' }}</td>
                                    <td>{{ $login->ip_address ?? '-' }}</td>
                                    <td>
                                        @if($login->status == 'success')
                                            <span class="badge bg-success">Success</span>
                                        @elseif($login->status == 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @else
                                            <span class="badge bg-warning">Blocked</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">No login history yet.</p>
            @endif
        </div>

        {{-- ACTIVE SESSIONS --}}
        <div class="card auth-card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="bi bi-display me-2"></i>Active Sessions</h5>
                <form method="POST" action="{{ route('logout.all') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Logout from all devices?')">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout All
                    </button>
                </form>
            </div>
            @if($userSessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
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
                                    <td>{{ $session->device_type ?? '-' }} @if($session->is_current)<span class="badge bg-success">Current</span>@endif</td>
                                    <td>{{ $session->ip_address ?? '-' }}</td>
                                    <td>{{ $session->last_activity->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">No active sessions.</p>
            @endif
        </div>
    </div>

    <div class="col-lg-7">
        {{-- PROFILE INFO --}}
        <div class="card auth-card p-3 mb-3">
            <h5 class="mb-3"><i class="bi bi-person me-2"></i>Profile Information</h5>
            <div class="d-flex align-items-center mb-3">
                @if($user->profile_pic)
                    <img src="{{ asset('storage/' . $user->profile_pic) }}" class="rounded-circle me-3" width="80" height="80" alt="Profile">
                @else
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:80px;height:80px;font-size:2rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <div class="fw-bold">{{ $user->name }}</div>
                    <div class="text-muted">{{ $user->email }}</div>
                    @if($user->hasVerifiedEmail())
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Verified</span>
                    @else
                        <span class="badge bg-warning"><i class="bi bi-exclamation-circle me-1"></i>Unverified</span>
                    @endif
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('profile.form') }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil me-1"></i>Edit Profile</a>
                <a href="{{ route('profile.security') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-shield me-1"></i>Security</a>
            </div>
        </div>

        {{-- LOGIN CHART (Simple HTML bars) --}}
        <div class="card auth-card p-3">
            <h5 class="mb-3"><i class="bi bi-bar-chart me-2"></i>Your Last 7 Days Activity</h5>
            @php
                $chartData = $recentLoginsChart;
                $maxCount = $chartData->max('count') ?: 1;
            @endphp
            <div class="d-flex align-items-end gap-2" style="height: 200px;">
                @for($i = 6; $i >= 0; $i--)
                    @php
                        $date = now()->subDays($i);
                        $dayData = $chartData->firstWhere('date', $date->format('Y-m-d'));
                        $count = $dayData ? $dayData->count : 0;
                        $height = ($count / $maxCount) * 100;
                    @endphp
                    <div class="flex-fill text-center">
                        <div class="bg-success mx-auto rounded" style="width: 100%; height: {{ max($height, 2) }}%; max-height: 180px;"></div>
                        <div class="small text-muted mt-1">{{ $date->format('D') }}</div>
                        <div class="fw-bold">{{ $count }}</div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection
