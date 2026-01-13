@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card auth-card p-4">
            <h3 class="text-center mb-3"> Register</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter name">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email">
                </div>

                <button class="btn btn-primary w-100">
                    Register & Generate Key
                </button>
            </form>

            <div class="text-center mt-3">
                Already registered?
                <a href="{{ route('login.form') }}">Login</a>
            </div>
        </div>
    </div>
</div>
@endsection