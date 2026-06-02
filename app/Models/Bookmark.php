<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    protected $fillable = ['topic_id', 'session_id'];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}
