<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('is_approved', true)->orderBy('created_at', 'desc');
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function ratedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ratings')
                    ->withPivot('rating')
                    ->withTimestamps();
    }

    // ===== SCOPES =====
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // ===== ACCESSORS (Kiến trúc chuẩn Laravel 11) =====
    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->thumbnail
                ? asset('storage/' . $this->thumbnail)
                : asset('images/default-post.jpg')
        );
    }

    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: fn () => (float) ($this->ratedByUsers()->avg('rating') ?? 0)
        );
    }

    protected function ratingCount(): Attribute
    {
        return Attribute::make(
            get: fn () => (int) $this->ratedByUsers()->count()
        );
    }

    // ===== MODEL EVENTS =====
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title) . '-' . Str::lower(Str::random(6));
            }
            if (empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 200);
            }
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
