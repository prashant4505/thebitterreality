<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoricalFigure extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'featured_image', 'born', 'died', 'era', 'region', 'category', 'is_published', 'view_count',
    ];

    protected $casts = ['is_published' => 'boolean'];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(HistoricalFigureTranslation::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'topic_figures')->withPivot('role');
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

    public function name(): string { return $this->trans('name') ?? $this->slug; }
    public function title(): ?string { return $this->trans('title'); }
    public function shortBio(): ?string { return $this->trans('short_bio'); }
    public function fullBio(): ?string { return $this->trans('full_bio'); }
    public function quotes(): array
    {
        $raw = $this->trans('quotes');
        if (is_array($raw)) return $raw;
        return json_decode($raw ?? '[]', true);
    }

    public function imageUrl(): string
    {
        return $this->featured_image
            ? asset('storage/' . $this->featured_image)
            : asset('images/default-figure.svg');
    }

    public function routeUrl(string $locale = null): string
    {
        $locale ??= app()->getLocale();
        return $locale === 'en'
            ? route('figure.show', $this->slug)
            : route('hi.figure.show', $this->slug);
    }
}
