<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Kiểm tra quyền submit form này
     * true = tất cả đã đăng nhập đều được (middleware admin đã xử lý rồi)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Quy tắc validation
     *
     * Giải thích các rule:
     * - required: bắt buộc nhập
     * - string: phải là chuỗi ký tự
     * - max:255: tối đa 255 ký tự
     * - unique:categories,slug: slug phải unique trong bảng categories
     * - nullable: có thể để trống
     * - boolean: giá trị 0 hoặc 1
     * - integer: số nguyên
     * - min:0: giá trị tối thiểu là 0
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:categories,slug', 'regex:/^[a-z0-9-]+$/'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh bằng tiếng Việt
     */
    public function messages(): array
    {
        return [
            'name.required'  => 'Tên danh mục không được để trống.',
            'name.max'       => 'Tên danh mục tối đa :max ký tự.',
            'slug.unique'    => 'Slug này đã được dùng. Vui lòng chọn slug khác.',
            'slug.regex'     => 'Slug chỉ được chứa chữ thường, số và dấu gạch ngang.',
        ];
    }
}
