@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card auth-card p-4">
            <h3 class="mb-3"><i class="bi bi-person-gear me-2"></i>Edit Profile</h3>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="text-center mb-3">
                    @if($user->profile_pic)
                        <img src="{{ asset('storage/' . $user->profile_pic) }}" class="rounded-circle mb-2" width="120" height="120" alt="Profile">
                    @else
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:120px;height:120px;font-size:3rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile_pic" class="form-control" accept="image/*">
                    @if($user->profile_pic)
                        <div class="form-text">Current: <a href="{{ asset('storage/' . $user->profile_pic) }}" target="_blank">View</a></div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-fill">Save Changes</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
