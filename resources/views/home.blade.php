@extends('layouts.app')

@section('title', 'Trang chủ - Cẩm Nang Du Lịch')

@section('content')

{{-- HERO SECTION --}}
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">
            <i class="bi bi-compass me-3"></i>Cẩm Nang Du Lịch Việt Nam
        </h1>
        <p class="lead mb-4">Khám phá những điểm đến tuyệt vời, chia sẻ kinh nghiệm du lịch cùng cộng đồng.</p>

        {{-- Search bar trên hero --}}
        <form action="{{ route('search') }}" method="GET" class="d-flex justify-content-center gap-2">
            <input type="text" name="q" class="form-control form-control-lg"
                   style="max-width: 400px;" placeholder="Tìm kiếm địa điểm, kinh nghiệm...">
            <button type="submit" class="btn btn-light btn-lg px-4">
                <i class="bi bi-search me-2"></i>Tìm
            </button>
        </form>
    </div>
</section>

{{-- DANH MỤC --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Khám phá theo danh mục</h2>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">
            @foreach($categories as $category)
                <div class="col">
                    <a href="{{ route('categories.show', $category->slug) }}"
                       class="text-decoration-none">
                        <div class="card text-center h-100 border-0 shadow-sm category-card"
                             style="transition: transform 0.2s;">
                            <div class="card-body py-4">
                                <i class="{{ $category->icon ?? 'bi-folder' }} fs-2 text-primary mb-2"></i>
                                <h6 class="card-title mb-1">{{ $category->name }}</h6>
                                <small class="text-muted">{{ $category->posts_count }} bài viết</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- BÀI VIẾT NỔI BẬT --}}
@if($featuredPosts->isNotEmpty())
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-fire text-danger me-2"></i>Bài viết nổi bật
            </h2>
            <a href="{{ route('posts.index', ['sort' => 'popular']) }}" class="btn btn-outline-primary btn-sm">
                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            {{-- Bài viết đầu tiên to hơn --}}
            <div class="col-md-6">
                <div class="card post-card h-100">
                    <img src="{{ $featuredPosts[0]->thumbnail_url }}"
                         class="card-img-top"
                         alt="{{ $featuredPosts[0]->title }}"
                         style="height: 300px; object-fit: cover;">
                    <div class="card-body">
                        <span class="category-badge mb-2 d-inline-block">
                            {{ $featuredPosts[0]->category->name }}
                        </span>
                        <h4 class="card-title">
                            <a href="{{ route('posts.show', $featuredPosts[0]->slug) }}"
                               class="text-decoration-none text-dark stretched-link">
                                {{ $featuredPosts[0]->title }}
                            </a>
                        </h4>
                        <p class="text-muted small">{{ Str::limit($featuredPosts[0]->excerpt, 120) }}</p>
                        <div class="d-flex align-items-center justify-content-between text-muted small mt-auto">
                            <span><i class="bi bi-person me-1"></i>{{ $featuredPosts[0]->user->name }}</span>
                            <span><i class="bi bi-eye me-1"></i>{{ number_format($featuredPosts[0]->views) }} lượt xem</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2 bài viết còn lại --}}
            <div class="col-md-6">
                <div class="row g-4">
                    @foreach($featuredPosts->skip(1) as $post)
                        <div class="col-12">
                            <div class="card post-card">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <img src="{{ $post->thumbnail_url }}"
                                             alt="{{ $post->title }}"
                                             class="img-fluid rounded-start h-100"
                                             style="object-fit: cover;">
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body py-2">
                                            <span class="category-badge mb-1 d-inline-block">
                                                {{ $post->category->name }}
                                            </span>
                                            <h6 class="card-title">
                                                <a href="{{ route('posts.show', $post->slug) }}"
                                                   class="text-decoration-none text-dark stretched-link">
                                                    {{ $post->title }}
                                                </a>
                                            </h6>
                                            <div class="text-muted small">
                                                <i class="bi bi-eye me-1"></i>{{ number_format($post->views) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- BÀI VIẾT MỚI NHẤT --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-clock-history me-2"></i>Bài viết mới nhất
            </h2>
            <a href="{{ route('posts.index') }}" class="btn btn-outline-primary btn-sm">
                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($latestPosts as $post)
                <div class="col">
                    @include('partials.post-card', ['post' => $post])
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA đăng ký --}}
@guest
<section class="py-5 text-center" style="background: linear-gradient(135deg, #2c7873, #6fb3b8);">
    <div class="container text-white">
        <h3 class="fw-bold mb-3">Bạn có muốn chia sẻ trải nghiệm du lịch?</h3>
        <p class="mb-4">Đăng ký tài khoản miễn phí để bình luận và lưu bài viết yêu thích!</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
            Đăng ký ngay <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>
</section>
@endguest

@endsection

@push('styles')
<style>
.category-card:hover {
    transform: translateY(-5px);
}
</style>
@endpush
