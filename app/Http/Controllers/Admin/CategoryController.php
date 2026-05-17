<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Danh sách danh mục
     */
    public function index()
    {
        // withCount: đếm số bài viết theo từng danh mục
        $categories = Category::withCount('posts')
            ->orderBy('sort_order')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Form tạo danh mục mới
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Lưu danh mục mới vào database
     */
    public function store(StoreCategoryRequest $request)
    {
        // $request->validated() chỉ lấy các field đã khai báo trong Form Request
        // Tự động loại bỏ các field thừa hoặc độc hại
        $data = $request->validated();

        // Tạo slug tự động nếu chưa nhập
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Đã tạo danh mục "' . $data['name'] . '" thành công!');
    }

    /**
     * Hiển thị chi tiết (không cần trong admin, redirect về edit)
     */
    public function show(Category $category)
    {
        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Form chỉnh sửa danh mục
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Cập nhật danh mục
     *
     * Laravel tự động tìm Category theo ID trong URL (Route Model Binding)
     * Không cần viết: Category::find($id)
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Đã cập nhật danh mục thành công!');
    }

    /**
     * Xóa danh mục
     * Lưu ý: Không xóa được nếu còn bài viết (do onDelete('restrict') trong migration)
     */
    public function destroy(Category $category)
    {
        // Kiểm tra xem danh mục có bài viết không
        if ($category->posts()->count() > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục đang có bài viết. Hãy chuyển bài viết sang danh mục khác trước.');
        }

        $name = $category->name;
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Đã xóa danh mục "' . $name . '"!');
    }
}
