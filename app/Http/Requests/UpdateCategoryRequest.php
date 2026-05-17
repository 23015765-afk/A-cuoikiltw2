<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // $this->route('category') = Category đang được sửa
        // Rule::unique()->ignore() = bỏ qua record hiện tại khi check unique
        // (cần thiết vì không lẽ khi sửa lại bắt thay slug mới)
        return [
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($this->route('category')),
                'regex:/^[a-z0-9-]+$/'
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục không được để trống.',
            'slug.unique'   => 'Slug này đã được dùng. Vui lòng chọn slug khác.',
            'slug.regex'    => 'Slug chỉ được chứa chữ thường, số và dấu gạch ngang.',
        ];
    }
}
