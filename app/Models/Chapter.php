<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    protected $fillable = [
        'topic_id', 'slug', 'sort_order', 'featured_image', 'reading_time', 'is_published',
    ];

    protected $casts = ['is_published' => 'boolean'];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ChapterTranslation::class);
    }

    public function trans(string $field, string $locale = null): mixed
    {
        $locale ??= app()->getLocale();
        $t = $this->relationLoaded('translations')
            ? ($this->translations->firstWhere('locale', $locale)
                ?? $this->translations->firstWhere('locale', 'en'))
            : ($this->translations()->where('locale', $locale)->first()
                ?? $this->translations()->where('locale', 'en')->first());

        return $t?->$field;
    }

    public function title(): string { return $this->trans('title') ?? $this->slug; }
    public function content(): ?string { return $this->trans('content'); }
    public function summary(): ?string { return $this->trans('summary'); }

    private function jsonField(string $field): array
    {
        $val = $this->trans($field);
        if (is_array($val)) return $val;
        if (is_string($val)) return json_decode($val, true) ?? [];
        return [];
    }

    public function pullQuotes(): array { return $this->jsonField('pull_quotes'); }
    public function factBoxes(): array { return $this->jsonField('fact_boxes'); }
    public function keyLessons(): array { return $this->jsonField('key_lessons'); }
    public function mythsVsFacts(): array { return $this->jsonField('myths_vs_facts'); }
}
