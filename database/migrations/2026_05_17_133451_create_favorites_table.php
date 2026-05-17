<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng favorites — bài viết yêu thích
     *
     * Đây là bảng TRUNG GIAN cho quan hệ N-N giữa users và posts.
     * 1 User có thể yêu thích nhiều Post.
     * 1 Post có thể được nhiều User yêu thích.
     *
     * unique(['user_id', 'post_id']) — mỗi user chỉ yêu thích 1 bài 1 lần
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ràng buộc: user không thể thích cùng 1 bài 2 lần
            $table->unique(['user_id', 'post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
