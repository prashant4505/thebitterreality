<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaticPage extends Model
{
    protected $fillable = ['slug', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];

    public function translations(): HasMany
    {
        return $this->hasMany(StaticPageTranslation::class);
    }

    public function trans(string $field, string $locale = null): ?string
    {
        $locale ??= app()->getLocale();
        $t = $this->translations()->where('locale', $locale)->first()
            ?? $this->translations()->where('locale', 'en')->first();
        return $t?->$field;
    }

    public function title(): string { return $this->trans('title') ?? $this->slug; }
    public function content(): ?string { return $this->trans('content'); }
}
