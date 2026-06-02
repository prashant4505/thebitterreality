<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'category_id', 'user_id', 'featured_image', 'era', 'region',
        'difficulty', 'reading_time', 'is_featured', 'is_published', 'published_at', 'view_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // --- Relationships ---

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(TopicTranslation::class);
    }

    public function translation(string $locale = null): HasOne
    {
        return $this->hasOne(TopicTranslation::class)
            ->where('locale', $locale ?? app()->getLocale());
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('sort_order');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'topic_tags');
    }

    public function figures(): BelongsToMany
    {
        return $this->belongsToMany(HistoricalFigure::class, 'topic_figures')->withPivot('role');
    }

    public function relatedTopics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'topic_relations', 'topic_id', 'related_topic_id')
            ->withPivot('relation_type');
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(Timeline::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(TopicView::class);
    }

    // --- Translation helpers ---

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
    public function subtitle(): ?string { return $this->trans('subtitle'); }
    public function excerpt(): ?string { return $this->trans('excerpt'); }
    public function overview(): ?string { return $this->trans('overview'); }

    public function imageUrl(): string
    {
        return $this->featured_image
            ? asset('storage/' . $this->featured_image)
            : asset('images/default-topic.svg');
    }

    public function routeUrl(string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $categorySlug = $this->category?->slug ?? 'general';
        return $locale === 'en'
            ? route('topic.show', [$categorySlug, $this->slug])
            : route('hi.topic.show', [$categorySlug, $this->slug]);
    }
}
