<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopicView extends Model
{
    public $timestamps = false;

    protected $fillable = ['topic_id', 'ip_address', 'session_id', 'viewed_at'];

    protected $casts = ['viewed_at' => 'datetime'];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}
