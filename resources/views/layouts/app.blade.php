<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- App CSS (Bootstrap + Custom) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>

    {{-- Thanh điều hướng --}}
    @include('layouts.navigation')

    {{-- Flash message thông báo --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    {{-- Nội dung chính --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')

    @stack('scripts')
</body>
</html>
