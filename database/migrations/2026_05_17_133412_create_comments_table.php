<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng comments — bình luận bài viết
     *
     * Quan hệ: 1 Post có nhiều Comment, 1 User viết nhiều Comment
     *
     * - post_id: FK → posts.id (bài viết được bình luận)
     * - user_id: FK → users.id (người bình luận)
     * - content: nội dung bình luận
     * - is_approved: kiểm duyệt (0=chờ duyệt, 1=đã duyệt)
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();

            // Index để lấy comment của 1 bài viết nhanh hơn
            $table->index(['post_id', 'is_approved']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
