<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // ===== HELPER METHODS =====
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Áp dụng kiến trúc Cast Attribute mới của Laravel 11 thay thế GetAttribute cũ
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->avatar
                ? asset('storage/' . $this->avatar)
                : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=2c7873&color=fff'
        );
    }

    // ===== RELATIONSHIPS =====
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function favoritePosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'favorites')->withTimestamps();
    }

    public function ratedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'ratings')
                    ->withPivot('rating')
                    ->withTimestamps();
    }
}
