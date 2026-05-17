<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // ===== RELATIONSHIPS =====

    /**
     * 1 Category có nhiều Post (quan hệ 1-N)
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Scope: chỉ lấy danh mục đang hoạt động
     * Dùng: Category::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // ===== EVENTS =====

    /**
     * Tự động tạo slug từ name trước khi lưu
     */
    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
