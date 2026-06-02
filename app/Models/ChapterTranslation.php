<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChapterTranslation extends Model
{
    protected $fillable = [
        'chapter_id', 'locale', 'title', 'content', 'summary',
        'pull_quotes', 'fact_boxes', 'key_lessons', 'myths_vs_facts',
    ];

    protected $casts = [
        'pull_quotes'   => 'array',
        'fact_boxes'    => 'array',
        'key_lessons'   => 'array',
        'myths_vs_facts' => 'array',
    ];

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }
}
