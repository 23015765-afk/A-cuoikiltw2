<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Toggle: Thêm vào / Xóa khỏi danh sách yêu thích
     */
    public function toggle(Post $post)
    {
        $user = auth()->user();

        // toggle() = nếu đã có thì xóa, chưa có thì thêm
        $user->favoritePosts()->toggle($post->id);

        $isFavorited = $user->favoritePosts()->where('post_id', $post->id)->exists();

        // Nếu là AJAX request → trả về JSON
        if (request()->expectsJson()) {
            return response()->json([
                'favorited' => $isFavorited,
                'message'   => $isFavorited ? 'Đã thêm vào yêu thích!' : 'Đã xóa khỏi yêu thích!',
            ]);
        }

        return redirect()->back()->with(
            'success',
            $isFavorited ? 'Đã thêm vào yêu thích!' : 'Đã xóa khỏi yêu thích!'
        );
    }

    /**
     * Danh sách bài viết yêu thích của user
     */
    public function index()
    {
        $favoritePosts = auth()->user()
            ->favoritePosts()
            ->with(['category', 'user'])
            ->where('status', 'published')
            ->paginate(9);

        return view('favorites.index', compact('favoritePosts'));
    }
}
