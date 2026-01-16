@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card auth-card p-4">

            <h3 class="mb-3">Welcome, {{ $user->name }}</h3>

            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">Name</th>
                    <td>{{ $user->name }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>

                <tr>
                    <th>Login Key</th>
                    <td>
                        <span class="badge bg-dark fs-6">
                            {{ $user->login_key }}
                        </span>
                    </td>
                </tr>
            </table>

            <div class="text-end mt-3">
                <a href="{{ route('logout') }}" class="btn btn-danger">
                    Logout
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
