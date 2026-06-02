<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimelineEntryTranslation extends Model
{
    protected $fillable = ['timeline_entry_id', 'locale', 'title', 'description'];

    public function entry(): BelongsTo
    {
        return $this->belongsTo(TimelineEntry::class, 'timeline_entry_id');
    }
}
