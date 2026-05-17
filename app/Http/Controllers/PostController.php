<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    /**
     * Danh sách bài viết công khai (có filter và phân trang)
     */
    public function index()
    {
        // Bắt đầu query với các điều kiện cơ bản
        $query = Post::with(['user', 'category'])->published();

        // Filter theo danh mục
        if (request('category')) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', request('category'));
            });
        }

        // Filter theo địa điểm
        if (request('location')) {
            $query->where('location', 'like', '%' . request('location') . '%');
        }

        // Sắp xếp
        $sort = request('sort', 'latest');
        match($sort) {
            'popular' => $query->orderBy('views', 'desc'),
            'oldest'  => $query->orderBy('created_at', 'asc'),
            default   => $query->orderBy('created_at', 'desc'),
        };

        // Phân trang 9 bài/trang, giữ lại query string trong URL
        $posts      = $query->paginate(9)->withQueryString();
        $categories = Category::active()->withCount(['posts' => fn($q) => $q->where('status', 'published')])->get();

        return view('posts.index', compact('posts', 'categories'));
    }

    /**
     * Xem chi tiết 1 bài viết
     */
    public function show(string $slug)
    {
        // Tìm bài viết theo slug (findOrFail = 404 nếu không tồn tại)
        $post = Post::with(['user', 'category', 'approvedComments.user', 'ratedByUsers'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Tăng lượt xem (increment = UPDATE posts SET views = views + 1 WHERE id = ?)
        $post->increment('views');

        // Bài viết liên quan (cùng danh mục, trừ bài hiện tại)
        $relatedPosts = Post::with(['user', 'category'])
            ->published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        // Kiểm tra user đăng nhập có yêu thích bài này không
        $isFavorited = false;
        $userRating  = null;

        if (auth()->check()) {
            $isFavorited = $post->favoritedByUsers()->where('user_id', auth()->id())->exists();
            $userRating  = $post->ratedByUsers()->where('user_id', auth()->id())->first()?->pivot?->rating;
        }

        return view('posts.show', compact('post', 'relatedPosts', 'isFavorited', 'userRating'));
    }
}
