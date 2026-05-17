<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Trang chủ website
     */
    public function index()
    {
        // Lấy 6 bài viết mới nhất đã published
        // with() = eager loading — tải sẵn user và category trong 1 query
        // (tránh N+1 query problem)
        $latestPosts = Post::with(['user', 'category'])
            ->published()
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Bài viết nổi bật (nhiều lượt xem nhất)
        $featuredPosts = Post::with(['user', 'category'])
            ->published()
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();

        // Tất cả danh mục đang hoạt động
        $categories = Category::active()
            ->withCount(['posts' => function ($q) {
                $q->where('status', 'published');
            }])
            ->get();

        return view('home', compact('latestPosts', 'featuredPosts', 'categories'));
    }
}
