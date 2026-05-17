<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Gửi bình luận mới
     */
    public function store(Request $request, Post $post)
    {
        // Validate
        $request->validate([
            'content' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'content.required' => 'Nội dung bình luận không được để trống.',
            'content.min'      => 'Bình luận phải có ít nhất :min ký tự.',
            'content.max'      => 'Bình luận tối đa :max ký tự.',
        ]);

        // Tạo comment
        Comment::create([
            'post_id'     => $post->id,
            'user_id'     => auth()->id(),
            'content'     => $request->content,
            'is_approved' => true, // Mặc định duyệt ngay
        ]);

        return redirect()
            ->route('posts.show', $post->slug)
            ->with('success', 'Đã gửi bình luận thành công!')
            ->fragment('comments'); // Scroll đến phần comment
    }

    /**
     * Xóa bình luận (chỉ chủ bình luận hoặc admin mới được xóa)
     */
    public function destroy(Comment $comment)
    {
        // Kiểm tra quyền: chỉ chủ comment hoặc admin
        if ($comment->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền xóa bình luận này.');
        }

        $postSlug = $comment->post->slug;
        $comment->delete();

        return redirect()
            ->route('posts.show', $postSlug)
            ->with('success', 'Đã xóa bình luận!')
            ->fragment('comments');
    }
}
