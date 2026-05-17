<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    // ===== RELATIONSHIPS =====

    /**
     * Comment thuộc về 1 Post
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Comment thuộc về 1 User (người bình luận)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ===== SCOPES =====

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
