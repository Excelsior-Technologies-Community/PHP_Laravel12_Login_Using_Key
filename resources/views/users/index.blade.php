<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Users - Key Auth System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f7fb;
            color: #1f2937;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", sans-serif;
        }

        .page-wrapper {
            min-height: 100vh;
            padding: 35px 20px;
        }

        .page-container {
            max-width: 1500px;
            margin: 0 auto;
        }

        /* =====================================================
           HEADER
        ====================================================== */

        .page-header {
            margin-bottom: 28px;
        }

        .page-title {
            font-size: 30px;
            font-weight: 750;
            letter-spacing: -0.5px;
            margin-bottom: 5px;
        }

        .page-subtitle {
            color: #6b7280;
            margin: 0;
            font-size: 15px;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: #eaf2ff;
            color: #0d6efd;
            font-size: 22px;
            margin-right: 12px;
        }

        /* =====================================================
           BUTTONS
        ====================================================== */

        .btn {
            border-radius: 9px;
            font-weight: 600;
        }

        .dashboard-btn {
            padding: 10px 16px;
        }

        /* =====================================================
           ALERTS
        ====================================================== */

        .alert {
            border: 0;
            border-radius: 12px;
            padding: 14px 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        /* =====================================================
           MAIN CARD
        ====================================================== */

        .users-card {
            border: 0;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 8px 35px rgba(15, 23, 42, 0.07);
            overflow: hidden;
        }

        .users-card-header {
            padding: 24px 26px 20px;
            border-bottom: 1px solid #edf0f5;
        }

        .users-title {
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .users-description {
            color: #8a94a6;
            font-size: 13px;
        }

        /* =====================================================
           TOTAL USERS
        ====================================================== */

        .total-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 9px;
            background: #f1f5f9;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
        }

        .total-badge strong {
            color: #111827;
            font-size: 14px;
        }

        /* =====================================================
           TOOLBAR
        ====================================================== */

        .toolbar {
            padding: 20px 26px;
            background: #fbfcfe;
            border-bottom: 1px solid #edf0f5;
        }

        .search-box {
            max-width: 420px;
        }

        .search-box .input-group-text {
            background: #fff;
            border-right: 0;
            color: #8a94a6;
            padding-left: 14px;
        }

        .search-box .form-control {
            border-left: 0;
            padding: 11px 12px;
            box-shadow: none;
        }

        .search-box .form-control:focus {
            border-color: #dee2e6;
            box-shadow: none;
        }

        .search-box .btn {
            padding-left: 18px;
            padding-right: 18px;
        }

        .filter-label {
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .form-select {
            min-width: 180px;
            border-radius: 9px;
            padding: 10px 12px;
            border-color: #dfe4ea;
            font-size: 14px;
            box-shadow: none;
        }

        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .15rem rgba(13, 110, 253, .08);
        }

        /* =====================================================
           TABLE
        ====================================================== */

        .table-wrapper {
            padding: 0 12px;
        }

        .users-table {
            margin-bottom: 0;
        }

        .users-table thead th {
            background: #f8fafc;
            color: #64748b;
            border-bottom: 1px solid #e8edf3;
            border-top: 0;
            padding: 14px 14px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 750;
            white-space: nowrap;
        }

        .users-table tbody td {
            padding: 17px 14px;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: middle;
            color: #374151;
        }

        .users-table tbody tr {
            transition: background .15s ease;
        }

        .users-table tbody tr:hover {
            background: #fafcff;
        }

        .users-table tbody tr:last-child td {
            border-bottom: 0;
        }

        /* =====================================================
           SERIAL NUMBER
        ====================================================== */

        .serial-number {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #f1f5f9;
            color: #475569;
            font-weight: 700;
            font-size: 13px;
        }

        /* =====================================================
           AVATAR
        ====================================================== */

        .avatar {
            width: 44px;
            height: 44px;
            min-width: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0d6efd;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
        }

        .profile-image {
            width: 44px;
            height: 44px;
            min-width: 44px;
            border-radius: 12px;
            object-fit: cover;
        }

        .user-name {
            color: #111827;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .user-id {
            color: #9ca3af;
            font-size: 12px;
        }

        .email-text {
            color: #475569;
            font-size: 14px;
        }

        /* =====================================================
           STATUS
        ====================================================== */

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-verified {
            background: #eaf8ef;
            color: #198754;
        }

        .status-pending {
            background: #fff7df;
            color: #9a6700;
        }

        /* =====================================================
           REGISTERED DATE
        ====================================================== */

        .registered-date {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }

        .registered-time {
            display: block;
            color: #9ca3af;
            font-size: 11px;
            margin-top: 2px;
        }

        /* =====================================================
           ACTIONS
        ====================================================== */

        .current-user {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 10px;
            border-radius: 8px;
            background: #eaf2ff;
            color: #0d6efd;
            font-size: 11px;
            font-weight: 700;
        }

        .delete-btn {
            border-radius: 8px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 650;
        }

        /* =====================================================
           PAGINATION
        ====================================================== */

        .pagination-wrapper {
            padding: 20px 26px 24px;
            border-top: 1px solid #edf0f5;
        }

        .pagination {
            gap: 5px;
        }

        .pagination .page-item {
            margin: 0;
        }

        .pagination .page-link {
            border: 0;
            border-radius: 8px !important;
            min-width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            background: #f1f5f9;
            font-size: 13px;
            font-weight: 650;
            box-shadow: none;
        }

        .pagination .page-link:hover {
            background: #e2e8f0;
            color: #0d6efd;
        }

        .pagination .page-item.active .page-link {
            background: #0d6efd;
            color: #fff;
        }

        /* =====================================================
           EMPTY STATE
        ====================================================== */

        .empty-state {
            padding: 80px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 72px;
            height: 72px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: #f1f5f9;
            color: #94a3b8;
            font-size: 30px;
            margin-bottom: 18px;
        }

        .empty-state h5 {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: 14px;
        }

        /* =====================================================
           FOOTER
        ====================================================== */

        .page-footer {
            margin-top: 20px;
        }

        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 768px) {

            .page-wrapper {
                padding: 20px 12px;
            }

            .page-title {
                font-size: 24px;
            }

            .users-card-header,
            .toolbar,
            .pagination-wrapper {
                padding-left: 17px;
                padding-right: 17px;
            }

            .search-box {
                max-width: 100%;
            }

            .sort-area {
                width: 100%;
            }

            .sort-area .form-select {
                width: 100%;
            }

            .table-wrapper {
                padding: 0 5px;
            }

        }

    </style>

</head>

<body>

<div class="page-wrapper">

    <div class="page-container">

        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="page-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center">

                    <div class="header-icon">

                        <i class="bi bi-people-fill"></i>

                    </div>

                    <div>

                        <h1 class="page-title">
                            Users
                        </h1>

                        <p class="page-subtitle">
                            Manage registered users in your Key Auth system.
                        </p>

                    </div>

                </div>


                <a
                    href="{{ route('dashboard') }}"
                    class="btn btn-outline-primary dashboard-btn">

                    <i class="bi bi-speedometer2 me-1"></i>

                    Dashboard

                </a>

            </div>

        </div>


        {{-- =====================================================
             SUCCESS MESSAGE
        ====================================================== --}}

        @if(session('success'))

            <div
                class="alert alert-success alert-dismissible fade show mb-4"
                role="alert">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- =====================================================
             ERROR MESSAGE
        ====================================================== --}}

        @if(session('error'))

            <div
                class="alert alert-danger alert-dismissible fade show mb-4"
                role="alert">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- =====================================================
             VALIDATION ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div
                class="alert alert-danger alert-dismissible fade show mb-4"
                role="alert">

                <strong>
                    <i class="bi bi-exclamation-circle me-1"></i>
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

        @endif


        {{-- =====================================================
             USERS CARD
        ====================================================== --}}

        <div class="users-card">


            {{-- =================================================
                 CARD HEADER
            ================================================== --}}

            <div class="users-card-header">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <div class="users-title">

                            <i class="bi bi-person-lines-fill me-2 text-primary"></i>

                            Registered Users

                        </div>

                        <div class="users-description">

                            View, search, sort and manage your registered users.

                        </div>

                    </div>


                    <div class="total-badge">

                        <i class="bi bi-people-fill"></i>

                        Total:

                        <strong>
                            {{ $users->total() }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 TOOLBAR
            ================================================== --}}

            <div class="toolbar">

                <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">


                    {{-- SEARCH --}}

                    <form
                        method="GET"
                        action="{{ route('users.index') }}"
                        class="search-box w-100 w-md-auto">

                        {{-- Keep sorting --}}

                        <input
                            type="hidden"
                            name="sort_by"
                            value="{{ request('sort_by', 'id') }}">

                        <input
                            type="hidden"
                            name="sort_order"
                            value="{{ request('sort_order', 'asc') }}">


                        <label class="filter-label">
                            Search Users
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="bi bi-search"></i>

                            </span>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Search name, email or ID...">

                            @if(request('search'))

                                <a
                                    href="{{ route('users.index', [
                                        'sort_by' => request('sort_by', 'id'),
                                        'sort_order' => request('sort_order', 'asc')
                                    ]) }}"
                                    class="btn btn-outline-secondary">

                                    <i class="bi bi-x-lg"></i>

                                </a>

                            @endif

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="bi bi-search me-1"></i>

                                Search

                            </button>

                        </div>

                    </form>


                    {{-- SORTING --}}

                    <form
                        method="GET"
                        action="{{ route('users.index') }}"
                        class="d-flex align-items-end flex-wrap gap-2 sort-area">

                        <input
                            type="hidden"
                            name="search"
                            value="{{ request('search') }}">


                        <div>

                            <label class="filter-label">
                                Sort By
                            </label>

                            <select
                                name="sort_by"
                                class="form-select"
                                onchange="this.form.submit()">

                                <option
                                    value="id"
                                    {{ request('sort_by', 'id') == 'id' ? 'selected' : '' }}>

                                    User ID

                                </option>

                                <option
                                    value="name"
                                    {{ request('sort_by') == 'name' ? 'selected' : '' }}>

                                    Name

                                </option>

                                <option
                                    value="email"
                                    {{ request('sort_by') == 'email' ? 'selected' : '' }}>

                                    Email

                                </option>

                                <option
                                    value="created_at"
                                    {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>

                                    Registered Date

                                </option>

                            </select>

                        </div>


                        <div>

                            <label class="filter-label">
                                Order
                            </label>

                            <select
                                name="sort_order"
                                class="form-select"
                                onchange="this.form.submit()">

                                <option
                                    value="asc"
                                    {{ request('sort_order', 'asc') == 'asc' ? 'selected' : '' }}>

                                    Ascending

                                </option>

                                <option
                                    value="desc"
                                    {{ request('sort_order') == 'desc' ? 'selected' : '' }}>

                                    Descending

                                </option>

                            </select>

                        </div>

                    </form>

                </div>

            </div>


            {{-- =================================================
                 TABLE
            ================================================== --}}

            @if($users->count() > 0)

                <div class="table-responsive table-wrapper">

                    <table class="table users-table align-middle">

                        <thead>

                            <tr>

                                <th style="width: 70px;">
                                    #
                                </th>

                                <th>
                                    User
                                </th>

                                <th>
                                    Email
                                </th>

                                <th>
                                    Email Status
                                </th>

                                <th>
                                    Registered
                                </th>

                                <th class="text-end">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($users as $user)

                                <tr>


                                    {{-- =================================================
                                         SERIAL NUMBER
                                    ================================================== --}}

                                    <td>

                                        <span class="serial-number">

                                            {{ $users->firstItem() + $loop->index }}

                                        </span>

                                    </td>


                                    {{-- =================================================
                                         USER
                                    ================================================== --}}

                                    <td>

                                        <div class="d-flex align-items-center">

                                            @if($user->profile_pic)

                                                <img
                                                    src="{{ asset('storage/' . $user->profile_pic) }}"
                                                    alt="{{ $user->name }}"
                                                    class="profile-image me-3">

                                            @else

                                                <div class="avatar me-3">

                                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}

                                                </div>

                                            @endif


                                            <div>

                                                <div class="user-name">

                                                    {{ $user->name }}

                                                </div>

                                                <div class="user-id">

                                                    <i class="bi bi-person-badge me-1"></i>

                                                    User ID: {{ $user->id }}

                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- =================================================
                                         EMAIL
                                    ================================================== --}}

                                    <td>

                                        <span class="email-text">

                                            <i class="bi bi-envelope me-1 text-muted"></i>

                                            {{ $user->email }}

                                        </span>

                                    </td>


                                    {{-- =================================================
                                         EMAIL STATUS
                                    ================================================== --}}

                                    <td>

                                        @if($user->hasVerifiedEmail())

                                            <span class="status-badge status-verified">

                                                <i class="bi bi-check-circle-fill"></i>

                                                Verified

                                            </span>

                                        @else

                                            <span class="status-badge status-pending">

                                                <i class="bi bi-clock-fill"></i>

                                                Not Verified

                                            </span>

                                        @endif

                                    </td>


                                    {{-- =================================================
                                         REGISTERED DATE
                                    ================================================== --}}

                                    <td>

                                        @if($user->created_at)

                                            <span class="registered-date">

                                                {{ $user->created_at->format('M d, Y') }}

                                            </span>

                                            <span class="registered-time">

                                                <i class="bi bi-clock me-1"></i>

                                                {{ $user->created_at->format('h:i A') }}

                                            </span>

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- =================================================
                                         ACTION
                                    ================================================== --}}

                                    <td class="text-end">

                                        @if($user->id == session('keyauth_user'))

                                            <span class="current-user">

                                                <i class="bi bi-person-check-fill"></i>

                                                Current User

                                            </span>

                                        @else

                                            <form
                                                method="POST"
                                                action="{{ route('users.delete', $user->id) }}"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger delete-btn">

                                                    <i class="bi bi-trash3 me-1"></i>

                                                    Delete

                                                </button>

                                            </form>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                     PAGINATION - NUMBERS ONLY
                ================================================== --}}

                @if($users->hasPages())

                    <div class="pagination-wrapper">

                        <nav aria-label="Users pagination">

                            <ul class="pagination justify-content-center mb-0">

                                @for($page = 1; $page <= $users->lastPage(); $page++)

                                    <li
                                        class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">

                                        <a
                                            class="page-link"
                                            href="{{ $users->url($page) }}">

                                            {{ $page }}

                                        </a>

                                    </li>

                                @endfor

                            </ul>

                        </nav>

                    </div>

                @endif


            @else

                {{-- =================================================
                     EMPTY STATE
                ================================================== --}}

                <div class="empty-state">

                    <div class="empty-icon">

                        <i class="bi bi-people"></i>

                    </div>

                    <h5>
                        No Users Found
                    </h5>


                    @if(request('search'))

                        <p>

                            No users match your search for

                            <strong>
                                "{{ request('search') }}"
                            </strong>.

                        </p>

                        <a
                            href="{{ route('users.index') }}"
                            class="btn btn-outline-primary">

                            <i class="bi bi-arrow-left me-1"></i>

                            Clear Search

                        </a>

                    @else

                        <p>
                            No registered users are available.
                        </p>

                    @endif

                </div>

            @endif

        </div>


        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <div class="page-footer">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <a
                    href="{{ route('dashboard') }}"
                    class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-left me-1"></i>

                    Back to Dashboard

                </a>


                <form
                    method="POST"
                    action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-danger">

                        <i class="bi bi-box-arrow-right me-1"></i>

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>

