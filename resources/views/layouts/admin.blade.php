<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Quản trị viên</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-light">

<div class="d-flex min-vh-100">

    {{-- SIDEBAR --}}
    <nav class="admin-sidebar d-flex flex-column p-3" style="width: 260px; min-width: 260px;">

        {{-- Logo --}}
        <a class="navbar-brand text-white mb-4 d-flex align-items-center gap-2"
           href="{{ route('admin.dashboard') }}">
            <i class="bi bi-compass fs-4"></i>
            <span class="fw-bold">Admin Panel</span>
        </a>

        {{-- Menu items --}}
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.posts.index') }}"
                   class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text me-2"></i>Bài viết
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}"
                   class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-grid me-2"></i>Danh mục
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}"
                   class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i>Người dùng
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.comments.index') }}"
                   class="nav-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots me-2"></i>Bình luận
                </a>
            </li>
        </ul>

        <div class="mt-auto">
            <hr class="border-secondary">
            <div class="d-flex align-items-center gap-2 text-secondary small mb-2">
                <img src="{{ auth()->user()->avatar_url }}"
                     class="rounded-circle" width="28" height="28">
                <span>{{ auth()->user()->name }}</span>
            </div>
            <a href="{{ route('home') }}" class="nav-link text-secondary">
                <i class="bi bi-house me-2"></i>Về trang chính
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-link text-danger w-100 text-start border-0 bg-transparent">
                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                </button>
            </form>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <div class="flex-grow-1 d-flex flex-column">

        {{-- Top bar --}}
        <header class="bg-white border-bottom px-4 py-3 d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h5>
            <small class="text-muted">{{ now()->format('d/m/Y H:i') }}</small>
        </header>

        {{-- Flash messages --}}
        <div class="px-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        {{-- Page content --}}
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
