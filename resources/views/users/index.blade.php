@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-1">All Users</h2>
        <p class="text-muted">Manage and search all registered users.</p>
    </div>
</div>

<div class="card auth-card p-3 mb-3">
    <form method="GET" action="{{ route('users.index') }}" class="row g-2">
        <div class="col-md-8">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i>Search
            </button>
        </div>
    </form>
</div>

<div class="card auth-card p-3">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>2FA</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($user->profile_pic)
                                    <img src="{{ asset('storage/' . $user->profile_pic) }}" class="rounded-circle me-2" width="32" height="32" alt="">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;font-size:0.8rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                {{ $user->name }}
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->hasVerifiedEmail())
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-warning">Unverified</span>
                            @endif
                        </td>
                        <td>
                            @if($user->hasConfirmedTwoFactor())
                                <span class="badge bg-success">Enabled</span>
                            @else
                                <span class="badge bg-secondary">Disabled</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</div>
@endsection
