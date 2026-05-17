@extends('layouts.app')

@section('title', $post->title . ' - Cẩm Nang Du Lịch')

@section('content')
<div class="container py-5">
    <div class="row">

        {{-- Nội dung bài viết --}}
        <div class="col-lg-8">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('categories.show', $post->category->slug) }}">
                            {{ $post->category->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ Str::limit($post->title, 40) }}</li>
                </ol>
            </nav>

            {{-- Tiêu đề và meta --}}
            <h1 class="fw-bold mb-3">{{ $post->title }}</h1>

            <div class="d-flex flex-wrap align-items-center gap-3 mb-4 text-muted small">
                <span class="category-badge">{{ $post->category->name }}</span>
                @if($post->location)
                    <span><i class="bi bi-geo-alt me-1"></i>{{ $post->location }}</span>
                @endif
                <span><i class="bi bi-person me-1"></i>{{ $post->user->name }}</span>
                <span><i class="bi bi-calendar me-1"></i>{{ $post->published_at->format('d/m/Y') }}</span>
                <span><i class="bi bi-eye me-1"></i>{{ number_format($post->views) }} lượt xem</span>
            </div>

            {{-- Ảnh thumbnail --}}
            <img src="{{ $post->thumbnail_url }}"
                 alt="{{ $post->title }}"
                 class="img-fluid rounded-3 mb-4 w-100"
                 style="max-height: 450px; object-fit: cover;">

            {{-- Nội dung HTML --}}
            <div class="post-content lh-lg">
                {!! $post->content !!}
            </div>

            {{-- Đánh giá sao --}}
            <div class="card border-0 shadow-sm rounded-3 p-4 my-5">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-star-fill text-warning me-2"></i>Đánh giá bài viết
                </h5>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="display-6 fw-bold">{{ number_format($post->average_rating, 1) }}</span>
                    <div>
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= round($post->average_rating) ? '-fill' : '' }} text-warning fs-5"></i>
                        @endfor
                        <div class="text-muted small">{{ $post->rating_count }} đánh giá</div>
                    </div>
                </div>

                @auth
                    <form action="{{ route('ratings.store', $post) }}" method="POST" id="rating-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Đánh giá của bạn:</label>
                            <div class="star-rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="star{{ $i }}"
                                           value="{{ $i }}"
                                           {{ $userRating == $i ? 'checked' : '' }}
                                           class="visually-hidden">
                                    <label for="star{{ $i }}" class="fs-4 cursor-pointer">
                                        <i class="bi bi-star-fill text-muted"></i>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="bi bi-check me-1"></i>Gửi đánh giá
                        </button>
                    </form>
                @else
                    <p class="text-muted">
                        <a href="{{ route('login') }}">Đăng nhập</a> để đánh giá bài viết.
                    </p>
                @endauth
            </div>

            {{-- Phần bình luận --}}
            <div id="comments" class="mt-5">
                <h4 class="fw-bold mb-4">
                    <i class="bi bi-chat-dots me-2"></i>
                    Bình luận ({{ $post->approvedComments->count() }})
                </h4>

                {{-- Form gửi bình luận --}}
                @auth
                    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                        <div class="d-flex gap-3">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 class="rounded-circle" width="40" height="40"
                                 style="object-fit: cover; flex-shrink: 0;">
                            <form action="{{ route('comments.store', $post) }}"
                                  method="POST" class="flex-grow-1">
                                @csrf
                                <textarea name="content"
                                          class="form-control mb-2 @error('content') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Chia sẻ nhận xét của bạn...">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-send me-1"></i>Gửi bình luận
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <a href="{{ route('login') }}">Đăng nhập</a> để bình luận bài viết này.
                    </div>
                @endauth

                {{-- Danh sách bình luận --}}
                @forelse($post->approvedComments as $comment)
                    <div class="d-flex gap-3 mb-4">
                        <img src="{{ $comment->user->avatar_url }}"
                             class="rounded-circle" width="40" height="40"
                             style="object-fit: cover; flex-shrink: 0;">
                        <div class="flex-grow-1">
                            <div class="bg-light rounded-3 p-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="small">{{ $comment->user->name }}</strong>
                                    <small class="text-muted">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                            {{-- Nút xóa (chủ comment hoặc admin) --}}
                            @auth
                                @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                    <form action="{{ route('comments.destroy', $comment) }}"
                                          method="POST" class="d-inline mt-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-link btn-sm text-danger p-0"
                                                onclick="return confirm('Xóa bình luận này?')">
                                            <i class="bi bi-trash me-1"></i>Xóa
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-4">
                        <i class="bi bi-chat-dots fs-2 d-block mb-2"></i>
                        Chưa có bình luận nào. Hãy là người đầu tiên!
                    </p>
                @endforelse
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Nút yêu thích --}}
            @auth
                <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 text-center">
                    <form action="{{ route('favorites.toggle', $post) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="btn {{ $isFavorited ? 'btn-danger' : 'btn-outline-danger' }} w-100">
                            <i class="bi bi-heart{{ $isFavorited ? '-fill' : '' }} me-2"></i>
                            {{ $isFavorited ? 'Đã yêu thích' : 'Thêm vào yêu thích' }}
                        </button>
                    </form>
                </div>
            @endauth

            {{-- Thông tin tác giả --}}
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                <h6 class="fw-bold mb-3">Tác giả</h6>
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $post->user->avatar_url }}"
                         class="rounded-circle" width="50" height="50"
                         style="object-fit: cover;">
                    <div>
                        <div class="fw-semibold">{{ $post->user->name }}</div>
                        <small class="text-muted">
                            {{ $post->user->posts()->where('status', 'published')->count() }} bài viết
                        </small>
                    </div>
                </div>
            </div>

            {{-- Bài viết liên quan --}}
            @if($relatedPosts->isNotEmpty())
                <div class="card border-0 shadow-sm rounded-3 p-4">
                    <h6 class="fw-bold mb-3">Bài viết liên quan</h6>
                    @foreach($relatedPosts as $related)
                        <div class="d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <img src="{{ $related->thumbnail_url }}"
                                 alt="{{ $related->title }}"
                                 class="rounded-2" width="70" height="70"
                                 style="object-fit: cover; flex-shrink: 0;">
                            <div>
                                <a href="{{ route('posts.show', $related->slug) }}"
                                   class="text-decoration-none text-dark fw-semibold small">
                                    {{ Str::limit($related->title, 60) }}
                                </a>
                                <div class="text-muted small mt-1">
                                    <i class="bi bi-eye me-1"></i>{{ number_format($related->views) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.post-content {
    font-size: 1.05rem;
    line-height: 1.8;
}
.post-content img {
    max-width: 100%;
    border-radius: 8px;
    margin: 1rem 0;
}
.post-content h2, .post-content h3 {
    margin-top: 1.5rem;
    font-weight: 700;
}

/* Star rating input */
.star-rating-input {
    display: flex;
    flex-direction: row-reverse;
    gap: 4px;
    width: fit-content;
}
.star-rating-input label i {
    transition: color 0.1s;
}
.star-rating-input input:checked ~ label i,
.star-rating-input label:hover i,
.star-rating-input label:hover ~ label i {
    color: #ffc107 !important;
}
</style>
@endpush
