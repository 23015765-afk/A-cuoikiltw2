<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng posts — bài viết du lịch
     *
     * Giải thích các cột:
     * - id: khóa chính
     * - user_id: FK → users.id (tác giả bài viết)
     * - category_id: FK → categories.id (danh mục)
     * - title: tiêu đề bài viết
     * - slug: URL thân thiện (duy nhất)
     * - excerpt: tóm tắt ngắn (~200 ký tự)
     * - content: nội dung đầy đủ (TEXT dài)
     * - thumbnail: đường dẫn ảnh đại diện
     * - location: địa điểm du lịch (VD: Hội An, Đà Lạt)
     * - status: trạng thái ('draft'=nháp, 'published'=đã đăng, 'archived'=lưu trữ)
     * - views: số lượt xem
     * - published_at: thời điểm đăng bài
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('thumbnail')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Index để tăng tốc độ tìm kiếm
            $table->index(['status', 'published_at']);
            $table->index('location');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
