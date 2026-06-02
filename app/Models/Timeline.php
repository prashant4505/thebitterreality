<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timeline extends Model
{
    protected $fillable = ['topic_id', 'slug', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(TimelineEntry::class)->orderBy('sort_order');
    }
}
