<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <i class="bi bi-compass text-primary fs-4"></i>
            <span>Cẩm Nang Du Lịch</span>
        </a>

        {{-- Toggle button mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            {{-- Menu trái --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}"
                       href="{{ route('home') }}">
                        <i class="bi bi-house me-1"></i>Trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('posts.*') ? 'active fw-bold' : '' }}"
                       href="{{ route('posts.index') }}">
                        <i class="bi bi-journal-text me-1"></i>Bài viết
                    </a>
                </li>

                {{-- Dropdown Danh mục --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-grid me-1"></i>Danh mục
                    </a>
                    <ul class="dropdown-menu">
                        @foreach(App\Models\Category::active()->get() as $cat)
                            <li>
                                <a class="dropdown-item" href="{{ route('categories.show', $cat->slug) }}">
                                    <i class="{{ $cat->icon ?? 'bi-folder' }} me-2"></i>{{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            {{-- Form tìm kiếm --}}
            <form class="d-flex me-3" action="{{ route('search') }}" method="GET">
                <div class="input-group">
                    <input class="form-control" type="search" name="q"
                           placeholder="Tìm kiếm..."
                           value="{{ request('q') }}"
                           style="width: 200px;">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            {{-- Menu phải: Đăng nhập/Đăng ký hoặc User menu --}}
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-2" href="{{ route('register') }}">
                            Đăng ký
                        </a>
                    </li>
                @else
                    {{-- Link Admin Dashboard --}}
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link text-danger fw-bold" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Admin
                            </a>
                        </li>
                    @endif

                    {{-- User dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           href="#" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="rounded-circle" width="28" height="28"
                                 style="object-fit: cover;">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header">{{ auth()->user()->email }}</li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('favorites.index') }}">
                                    <i class="bi bi-heart me-2"></i>Bài viết yêu thích
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>Hồ sơ
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
