<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng users — lưu thông tin người dùng
     *
     * Giải thích các cột:
     * - id: khóa chính, tự tăng
     * - name: tên hiển thị
     * - email: email (unique — không được trùng)
     * - email_verified_at: thời điểm xác minh email
     * - password: mật khẩu đã hash
     * - role: phân quyền ('user' hoặc 'admin')
     * - avatar: đường dẫn ảnh đại diện
     * - is_active: trạng thái tài khoản (1=hoạt động, 0=bị khóa)
     * - remember_token: token nhớ đăng nhập
     * - timestamps: created_at và updated_at (Laravel tự quản lý)
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
