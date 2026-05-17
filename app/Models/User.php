<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Danh sách cột được phép mass-assign (tránh lỗ hổng bảo mật)
     * Chỉ các cột trong $fillable mới được gán qua create() hoặc fill()
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_active',
    ];

    /**
     * Các cột ẩn khi convert sang JSON/Array (không lộ password ra API)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tự động cast kiểu dữ liệu
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // ===== HELPER METHODS =====

    /**
     * Kiểm tra user có phải Admin không
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Lấy URL avatar (dùng ảnh mặc định nếu chưa có)
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=2c7873&color=fff';
    }

    // ===== RELATIONSHIPS =====

    /**
     * 1 User viết nhiều Post (quan hệ 1-N)
     * User là "cha", Post là "con"
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 1 User viết nhiều Comment
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * User yêu thích nhiều Post (quan hệ N-N qua bảng favorites)
     * withTimestamps() để lưu created_at vào bảng trung gian
     */
    public function favoritePosts()
    {
        return $this->belongsToMany(Post::class, 'favorites')->withTimestamps();
    }

    /**
     * User đánh giá nhiều Post (quan hệ N-N qua bảng ratings)
     * withPivot('rating') để lấy cột rating từ bảng trung gian
     */
    public function ratedPosts()
    {
        return $this->belongsToMany(Post::class, 'ratings')
                    ->withPivot('rating')
                    ->withTimestamps();
    }
}
