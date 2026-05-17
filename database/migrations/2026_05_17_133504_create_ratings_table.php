<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng ratings — đánh giá bài viết (1-5 sao)
     *
     * Tương tự favorites, đây cũng là bảng trung gian N-N.
     * Thêm cột 'rating' để lưu số sao (1-5).
     *
     * unique(['user_id', 'post_id']) — mỗi user chỉ đánh giá 1 bài 1 lần
     * (nếu đánh giá lại → UPDATE thay vì INSERT)
     */
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->default(5); // 1-5 sao
            $table->timestamps();

            $table->unique(['user_id', 'post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
