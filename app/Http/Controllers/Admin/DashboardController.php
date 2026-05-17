<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== THỐNG KÊ TỔNG QUAN =====
        $stats = [
            'total_posts'    => Post::count(),
            'total_users'    => User::where('role', 'user')->count(),
            'total_comments' => Comment::count(),
            'total_views'    => Post::sum('views'),
            'published_posts'=> Post::where('status', 'published')->count(),
            'pending_posts'  => Post::where('status', 'draft')->count(),
        ];

        // ===== 10 BÀI VIẾT MỚI NHẤT =====
        $latestPosts = Post::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // ===== 5 COMMENT MỚI NHẤT =====
        $latestComments = Comment::with(['user', 'post'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // ===== THỐNG KÊ BÀI VIẾT THEO DANH MỤC =====
        $categoryStats = Category::withCount(['posts' => fn($q) => $q->where('status', 'published')])
            ->orderBy('posts_count', 'desc')
            ->get();

        // ===== THỐNG KÊ BÀI VIẾT 7 NGÀY GẦN NHẤT =====
        $weeklyStats = Post::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ===== TOP 5 BÀI VIẾT NHIỀU LƯỢT XEM =====
        $topPosts = Post::with(['user', 'category'])
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'latestPosts',
            'latestComments',
            'categoryStats',
            'weeklyStats',
            'topPosts'
        ));
    }
}
