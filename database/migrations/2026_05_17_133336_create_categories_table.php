<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng categories — danh mục bài viết
     *
     * Giải thích:
     * - id: khóa chính
     * - name: tên danh mục (VD: Ẩm thực, Địa điểm đẹp...)
     * - slug: URL thân thiện (VD: am-thuc, dia-diem-dep)
     * - description: mô tả danh mục
     * - icon: icon Bootstrap Icons (VD: bi-compass)
     * - is_active: ẩn/hiện danh mục
     * - sort_order: thứ tự hiển thị
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable()->default('bi-compass');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
