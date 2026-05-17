@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Thống Kê')

@section('content')

{{-- STAT CARDS --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-journal-text text-primary fs-4"></i>
                </div>
                <div>
                    <div class="h4 fw-bold mb-0">{{ number_format($stats['total_posts']) }}</div>
                    <div class="text-muted small">Tổng bài viết</div>
                    <div class="text-success small">
                        <i class="bi bi-check-circle me-1"></i>{{ $stats['published_posts'] }} đã đăng
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-people text-success fs-4"></i>
                </div>
                <div>
                    <div class="h4 fw-bold mb-0">{{ number_format($stats['total_users']) }}</div>
                    <div class="text-muted small">Người dùng</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-chat-dots text-warning fs-4"></i>
                </div>
                <div>
                    <div class="h4 fw-bold mb-0">{{ number_format($stats['total_comments']) }}</div>
                    <div class="text-muted small">Bình luận</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-eye text-info fs-4"></i>
                </div>
                <div>
                    <div class="h4 fw-bold mb-0">{{ number_format($stats['total_views']) }}</div>
                    <div class="text-muted small">Tổng lượt xem</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Bài viết mới nhất --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
                <h6 class="fw-bold mb-0">Bài viết mới nhất</h6>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Danh mục</th>
                                <th>Trạng thái</th>
                                <th>Lượt xem</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestPosts as $post)
                                <tr>
                                    <td>
                                        <div class="fw-semibold small">{{ Str::limit($post->title, 40) }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            {{ $post->user->name }} · {{ $post->created_at->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $post->category->name }}</span></td>
                                    <td>
                                        @if($post->status === 'published')
                                            <span class="badge bg-success">Đã đăng</span>
                                        @elseif($post->status === 'draft')
                                            <span class="badge bg-warning text-dark">Nháp</span>
                                        @else
                                            <span class="badge bg-secondary">Lưu trữ</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($post->views) }}</td>
                                    <td>
                                        <a href="{{ route('admin.posts.edit', $post) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar thống kê --}}
    <div class="col-lg-4">

        {{-- Top bài viết --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-trophy text-warning me-2"></i>Top bài viết</h6>
            </div>
            <div class="card-body p-0">
                @foreach($topPosts as $i => $post)
                    <div class="d-flex align-items-center gap-3 px-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <span class="fw-bold text-muted" style="min-width: 20px;">{{ $i + 1 }}</span>
                        <div class="flex-grow-1 small">
                            <div class="fw-semibold">{{ Str::limit($post->title, 35) }}</div>
                            <div class="text-muted">{{ number_format($post->views) }} lượt xem</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Bình luận mới --}}
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
                <h6 class="fw-bold mb-0">Bình luận mới</h6>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-outline-secondary">Xem thêm</a>
            </div>
            <div class="card-body p-0">
                @foreach($latestComments as $comment)
                    <div class="px-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <img src="{{ $comment->user->avatar_url }}"
                                 class="rounded-circle" width="24" height="24">
                            <strong class="small">{{ $comment->user->name }}</strong>
                            <small class="text-muted ms-auto">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="small text-muted mb-0">{{ Str::limit($comment->content, 60) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
