<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = ['topic_id', 'parent_id', 'author_name', 'author_email', 'body', 'is_approved', 'ip_address'];

    protected $casts = ['is_approved' => 'boolean'];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
