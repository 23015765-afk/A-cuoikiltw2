<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Đánh giá bài viết (1-5 sao)
     * Nếu đã đánh giá → cập nhật, chưa đánh giá → tạo mới
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ], [
            'rating.required' => 'Vui lòng chọn số sao.',
            'rating.min'      => 'Đánh giá tối thiểu 1 sao.',
            'rating.max'      => 'Đánh giá tối đa 5 sao.',
        ]);

        // syncWithoutDetaching = cập nhật nếu đã có, thêm mới nếu chưa
        // (an toàn hơn toggle cho trường hợp có cột pivot)
        auth()->user()->ratedPosts()->syncWithoutDetaching([
            $post->id => ['rating' => $request->rating]
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success'        => true,
                'average_rating' => round($post->fresh()->average_rating, 1),
                'rating_count'   => $post->fresh()->rating_count,
            ]);
        }

        return redirect()
            ->route('posts.show', $post->slug)
            ->with('success', 'Cảm ơn bạn đã đánh giá bài viết!');
    }
}
