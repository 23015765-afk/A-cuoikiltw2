<footer class="footer mt-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5 class="text-white mb-3">
                    <i class="bi bi-compass me-2"></i>Cẩm Nang Du Lịch
                </h5>
                <p>Website chia sẻ kinh nghiệm và cẩm nang du lịch Việt Nam.
                   Khám phá những điểm đến tuyệt vời cùng chúng tôi!</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-white mb-3">Danh mục</h6>
                <ul class="list-unstyled">
                    @foreach(App\Models\Category::active()->take(5)->get() as $cat)
                        <li class="mb-1">
                            <a href="{{ route('categories.show', $cat->slug) }}"
                               class="text-decoration-none text-secondary">
                                <i class="{{ $cat->icon ?? 'bi-chevron-right' }} me-1 small"></i>
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="text-white mb-3">Liên kết</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-secondary text-decoration-none">Trang chủ</a></li>
                    <li><a href="{{ route('posts.index') }}" class="text-secondary text-decoration-none">Bài viết</a></li>
                    <li><a href="{{ route('search') }}" class="text-secondary text-decoration-none">Tìm kiếm</a></li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <p class="text-center mb-0">
            &copy; {{ date('Y') }} Cẩm Nang Du Lịch. Được tạo bằng Laravel 11 & Bootstrap 5.
        </p>
    </div>
</footer>
