<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Danh sách bài viết (Admin có thể xem tất cả status)
     */
    public function index()
    {
        $posts = Post::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Form tạo bài viết mới
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Lưu bài viết mới
     *
     * Xử lý upload ảnh:
     * 1. Kiểm tra request có file thumbnail không
     * 2. Lưu file vào storage/app/public/thumbnails/
     * 3. Lấy đường dẫn và lưu vào database
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        // Xử lý upload ảnh thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadThumbnail($request->file('thumbnail'));
        }

        // Gán user_id = admin đang đăng nhập
        $data['user_id'] = auth()->id();

        // Tạo slug từ title
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(6);

        // Nếu status = published mà chưa có published_at
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $post = Post::create($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Đã tạo bài viết "' . $post->title . '" thành công!');
    }

    /**
     * Xem chi tiết bài viết (redirect về edit)
     */
    public function show(Post $post)
    {
        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Form chỉnh sửa bài viết
     */
    public function edit(Post $post)
    {
        $categories = Category::active()->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Cập nhật bài viết
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        // Xử lý upload ảnh mới (nếu có)
        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ trước khi upload ảnh mới
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $this->uploadThumbnail($request->file('thumbnail'));
        }

        // Cập nhật published_at nếu chuyển sang published
        if ($data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Đã cập nhật bài viết thành công!');
    }

    /**
     * Xóa bài viết (kèm xóa ảnh thumbnail)
     */
    public function destroy(Post $post)
    {
        // Xóa ảnh thumbnail khỏi storage trước khi xóa record
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $title = $post->title;
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Đã xóa bài viết "' . $title . '"!');
    }

    /**
     * Helper method: Upload và lưu ảnh thumbnail
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string Đường dẫn file trong storage
     */
    private function uploadThumbnail($file): string
    {
        // Tạo tên file unique: timestamp + random string + extension
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Lưu vào storage/app/public/thumbnails/
        // Disk 'public' = storage/app/public (đã symlink sang public/storage)
        $path = $file->storeAs('thumbnails', $filename, 'public');

        return $path; // VD: "thumbnails/1704067200_abc123def.jpg"
    }
}
