<div class="card post-card h-100">
    <a href="{{ route('posts.show', $post->slug) }}">
        <img src="{{ $post->thumbnail_url }}"
             class="card-img-top"
             alt="{{ $post->title }}"
             style="height: 200px; object-fit: cover;">
    </a>
    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="category-badge">{{ $post->category->name }}</span>
            @if($post->location)
                <small class="text-muted">
                    <i class="bi bi-geo-alt me-1"></i>{{ $post->location }}
                </small>
            @endif
        </div>

        <h5 class="card-title">
            <a href="{{ route('posts.show', $post->slug) }}"
               class="text-decoration-none text-dark">
                {{ $post->title }}
            </a>
        </h5>

        <p class="card-text text-muted small flex-grow-1">
            {{ Str::limit($post->excerpt, 100) }}
        </p>

        <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ $post->user->avatar_url }}"
                     alt="{{ $post->user->name }}"
                     class="rounded-circle" width="24" height="24"
                     style="object-fit: cover;">
                <small class="text-muted">{{ $post->user->name }}</small>
            </div>
            <div class="text-muted small">
                <i class="bi bi-eye me-1"></i>{{ number_format($post->views) }}
                @if($post->average_rating > 0)
                    <span class="ms-2">
                        <i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($post->average_rating, 1) }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
