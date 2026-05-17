<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cẩm Nang Du Lịch') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row g-4" style="display: flex; flex-wrap: wrap; margin-right: -1.5rem; margin-left: -1.5rem;">
                @isset($posts)
                    @forelse($posts as $post)
                        <div style="flex: 0 0 auto; width: 33.33333333%; padding-right: 1.5rem; padding-left: 1.5rem; margin-bottom: 2rem;">
                            @include('partials.post-card', ['post' => $post])
                        </div>
                    @empty
                        <div style="width: 100%; text-center: center; padding: 3rem 0;">
                            <p style="color: #6c757d;">Chưa có bài viết nào được xuất bản.</p>
                        </div>
                    @endforelse
                @else
                    <div style="width: 100%; text-center: center; padding: 3rem 0;">
                        <p style="color: #dc3545; font-weight: bold;">Lỗi: Không nhận được dữ liệu $posts từ Controller.</p>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</x-app-layout>
