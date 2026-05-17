<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'location',
        'status',
        'views',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'views'        => 'integer',
        ];
    }

    // ===== RELATIONSHIPS =====

    /**
     * Post thuộc về 1 User (tác giả)
     * Quan hệ N-1: nhiều Post thuộc 1 User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Post thuộc về 1 Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 1 Post có nhiều Comment
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Comment đã được duyệt
     */
    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true)->latest();
    }

    /**
     * Những User yêu thích bài này (N-N qua bảng favorites)
     */
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * Những User đánh giá bài này (N-N qua bảng ratings)
     */
    public function ratedByUsers()
    {
        return $this->belongsToMany(User::class, 'ratings')
                    ->withPivot('rating')
                    ->withTimestamps();
    }

    // ===== SCOPES =====

    /**
     * Chỉ lấy bài đã published
     * Dùng: Post::published()->get()
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Sắp xếp theo mới nhất
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // ===== ACCESSOR (thuộc tính tính toán) =====

    /**
     * URL ảnh thumbnail
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('images/default-post.jpg');
    }

    /**
     * Điểm đánh giá trung bình
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->ratedByUsers()->avg('rating') ?? 0;
    }

    /**
     * Số lượt đánh giá
     */
    public function getRatingCountAttribute(): int
    {
        return $this->ratedByUsers()->count();
    }

    // ===== EVENTS =====

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            // Tự động tạo slug từ title
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title) . '-' . Str::random(6);
            }
            // Tự động tạo excerpt từ content nếu chưa có
            if (empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 200);
            }
            // Nếu status là published mà chưa có published_at
            if ($post->status === 'published' && empty($post->published_at)) {
                $post->published_at = now();
            }
        });

        static::updating(function (Post $post) {
            if ($post->status === 'published' && empty($post->published_at)) {
                $post->published_at = now();
            }
        });
    }
}
