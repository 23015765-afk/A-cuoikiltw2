<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'content'     => ['required', 'string', 'min:100'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'location'    => ['nullable', 'string', 'max:255'],
            'status'      => ['required', 'in:draft,published,archived'],
            // Khi sửa, thumbnail là optional (nullable)
            'thumbnail'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'Tiêu đề bài viết không được để trống.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'content.required'     => 'Nội dung bài viết không được để trống.',
            'content.min'          => 'Nội dung bài viết phải có ít nhất :min ký tự.',
            'thumbnail.image'      => 'File phải là ảnh.',
            'thumbnail.max'        => 'Ảnh không được vượt quá 2MB.',
        ];
    }
}
