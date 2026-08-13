@extends('layouts.app')

@section('title', 'Active Sessions')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card auth-card p-4">
            <h3 class="mb-3"><i class="bi bi-display me-2"></i>Active Sessions</h3>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>IP Address</th>
                            <th>Last Active</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $session)
                            <tr class="{{ $session->is_current ? 'table-success' : '' }}">
                                <td>
                                    <i class="bi bi-{{ $session->device_type == 'mobile' ? 'phone' : ($session->device_type == 'tablet' ? 'tablet' : 'laptop') }} me-1"></i>
                                    {{ $session->device_type ?? 'Unknown' }}
                                    @if($session->is_current)
                                        <span class="badge bg-success ms-1">Current</span>
                                    @endif
                                </td>
                                <td>{{ $session->ip_address ?? '-' }}</td>
                                <td>{{ $session->last_activity->diffForHumans() }}</td>
                                <td>
                                    @if($session->is_current)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Idle</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No active sessions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
