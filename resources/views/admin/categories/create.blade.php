@extends('layouts.admin')

@section('title', 'Thêm danh mục')
@section('page-title', 'Thêm Danh Mục Mới')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="VD: Ẩm thực"
                               id="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Slug (URL)</label>
                        <input type="text"
                               name="slug"
                               class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug') }}"
                               placeholder="VD: am-thuc (tự động tạo nếu để trống)"
                               id="slug">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Chỉ dùng chữ thường, số và dấu gạch ngang.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả</label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Mô tả ngắn về danh mục...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Icon Bootstrap</label>
                            <input type="text"
                                   name="icon"
                                   class="form-control"
                                   value="{{ old('icon', 'bi-compass') }}"
                                   placeholder="bi-compass">
                            <div class="form-text">
                                Xem icon tại <a href="https://icons.getbootstrap.com" target="_blank">icons.getbootstrap.com</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Thứ tự hiển thị</label>
                            <input type="number"
                                   name="sort_order"
                                   class="form-control"
                                   value="{{ old('sort_order', 0) }}"
                                   min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Trạng thái</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       name="is_active" value="1"
                                       id="is_active"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Hiển thị</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Lưu danh mục
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Tự động tạo slug từ tên danh mục
document.getElementById('name').addEventListener('input', function() {
    const slugInput = document.getElementById('slug');
    if (slugInput.value === '') {
        slugInput.value = this.value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd').replace(/Đ/g, 'D')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
    }
});
</script>
@endpush
