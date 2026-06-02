<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimelineEntry extends Model
{
    protected $fillable = ['timeline_id', 'date_label', 'sort_order', 'image', 'type'];

    public function timeline(): BelongsTo
    {
        return $this->belongsTo(Timeline::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(TimelineEntryTranslation::class);
    }

    public function trans(string $field, string $locale = null): ?string
    {
        $locale ??= app()->getLocale();
        $t = $this->relationLoaded('translations')
            ? ($this->translations->firstWhere('locale', $locale)
                ?? $this->translations->firstWhere('locale', 'en'))
            : ($this->translations()->where('locale', $locale)->first()
                ?? $this->translations()->where('locale', 'en')->first());

        return $t?->$field;
    }

    public function title(): string { return $this->trans('title') ?? '—'; }
    public function description(): ?string { return $this->trans('description'); }
}
