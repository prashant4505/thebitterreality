<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    protected $fillable = ['slug', 'accent_color', 'icon', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function translation(string $locale = null): HasOne
    {
        return $this->hasOne(CategoryTranslation::class)
            ->where('locale', $locale ?? app()->getLocale());
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function trans(string $field, string $locale = null): ?string
    {
        $locale ??= app()->getLocale();
        $t = $this->relationLoaded('translations')
            ? $this->translations->firstWhere('locale', $locale)
                ?? $this->translations->firstWhere('locale', 'en')
            : $this->translations()->where('locale', $locale)->first()
                ?? $this->translations()->where('locale', 'en')->first();

        return $t?->$field;
    }

    public function name(): string { return $this->trans('name') ?? $this->slug; }
    public function description(): ?string { return $this->trans('description'); }

    public function routeUrl(string $locale = null): string
    {
        $locale ??= app()->getLocale();
        return $locale === 'en'
            ? route('category.show', $this->slug)
            : route('hi.category.show', $this->slug);
    }
}
