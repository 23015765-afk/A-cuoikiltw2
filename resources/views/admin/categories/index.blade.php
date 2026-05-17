@extends('layouts.admin')

@section('title', 'Quản lý danh mục')
@section('page-title', 'Quản lý Danh Mục')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Tổng: {{ $categories->total() }} danh mục</p>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Thêm danh mục
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Icon</th>
                        <th>Tên danh mục</th>
                        <th>Slug</th>
                        <th>Số bài viết</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="text-muted">{{ $category->id }}</td>
                            <td><i class="{{ $category->icon ?? 'bi-folder' }} fs-5 text-primary"></i></td>
                            <td>
                                <div class="fw-semibold">{{ $category->name }}</div>
                                <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                            </td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>
                                <span class="badge bg-primary rounded-pill">
                                    {{ $category->posts_count }}
                                </span>
                            </td>
                            <td>{{ $category->sort_order }}</td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Ẩn</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Xóa danh mục {{ $category->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Chưa có danh mục nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $categories->links() }}
</div>

@endsection
