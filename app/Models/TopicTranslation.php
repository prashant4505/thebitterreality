<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopicTranslation extends Model
{
    protected $fillable = [
        'topic_id', 'locale', 'title', 'subtitle', 'excerpt',
        'overview', 'meta_title', 'meta_description', 'keywords',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}
