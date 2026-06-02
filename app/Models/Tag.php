<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    protected $fillable = ['slug'];

    public function translations(): HasMany
    {
        return $this->hasMany(TagTranslation::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'topic_tags');
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

    public function name(): string
    {
        return $this->trans('name') ?? $this->slug;
    }
}
