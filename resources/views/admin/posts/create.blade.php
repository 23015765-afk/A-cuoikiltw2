@extends('layouts.admin')

@section('title', 'Thêm bài viết')
@section('page-title', 'Thêm Bài Viết Mới')

@section('content')

<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        {{-- Cột trái: Nội dung --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tiêu đề bài viết <span class="text-danger">*</span></label>
                        <input type="text"
                               name="title"
                               class="form-control form-control-lg @error('title') is-invalid @enderror"
                               value="{{ old('title') }}"
                               placeholder="Nhập tiêu đề hấp dẫn...">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tóm tắt</label>
                        <textarea name="excerpt"
                                  class="form-control @error('excerpt') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Mô tả ngắn gọn về bài viết (hiển thị trong danh sách)...">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nội dung <span class="text-danger">*</span></label>
                        <textarea name="content"
                                  id="content"
                                  class="form-control @error('content') is-invalid @enderror"
                                  rows="20"
                                  placeholder="Viết nội dung bài viết tại đây...">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Hỗ trợ HTML cơ bản: &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;strong&gt;, &lt;img&gt;</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cột phải: Cài đặt --}}
        <div class="col-lg-4">

            {{-- Xuất bản --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="fw-bold mb-0">Xuất bản</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Trạng thái</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                                📝 Nháp
                            </option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                                ✅ Đăng ngay
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-check-lg me-2"></i>Lưu
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                            Hủy
                        </a>
                    </div>
                </div>
            </div>

            {{-- Danh mục --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="fw-bold mb-0">Danh mục <span class="text-danger">*</span></h6>
                </div>
                <div class="card-body">
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Địa điểm --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="fw-bold mb-0">Địa điểm</h6>
                </div>
                <div class="card-body">
                    <input type="text"
                           name="location"
                           class="form-control"
                           value="{{ old('location') }}"
                           placeholder="VD: Hội An, Quảng Nam">
                </div>
            </div>

            {{-- Ảnh đại diện --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="fw-bold mb-0">Ảnh đại diện</h6>
                </div>
                <div class="card-body">
                    <input type="file"
                           name="thumbnail"
                           class="form-control @error('thumbnail') is-invalid @enderror"
                           id="thumbnail"
                           accept="image/jpeg,image/png,image/jpg,image/webp">
                    @error('thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">JPG, PNG, WebP. Tối đa 2MB.</div>

                    {{-- Preview ảnh --}}
                    <div id="img-preview" class="mt-3 d-none">
                        <img id="preview-img" src="" alt="Preview"
                             class="img-fluid rounded-2" style="max-height: 200px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
// Preview ảnh trước khi upload
document.getElementById('thumbnail').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('img-preview').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
