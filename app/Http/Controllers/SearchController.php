<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Tìm kiếm bài viết theo tiêu đề, nội dung, địa điểm
     */
    public function index(Request $request)
    {
        $keyword    = $request->get('q', '');
        $categoryId = $request->get('category');
        $location   = $request->get('location');

        $query = Post::with(['user', 'category'])->published();

        // Tìm theo từ khóa (tiêu đề hoặc nội dung)
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('content', 'like', "%{$keyword}%")
                  ->orWhere('location', 'like', "%{$keyword}%");
            });
        }

        // Filter theo danh mục
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        // Filter theo địa điểm
        if (!empty($location)) {
            $query->where('location', 'like', "%{$location}%");
        }

        $posts      = $query->orderBy('created_at', 'desc')->paginate(9)->withQueryString();
        $categories = Category::active()->get();

        return view('search.index', compact('posts', 'categories', 'keyword'));
    }
}
