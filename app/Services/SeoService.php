<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Str;

class SeoService
{
    public function page(string $title, ?string $description = null, ?string $image = null, ?string $type = 'website'): array
    {
        return [
            'title' => $title,
            'description' => $description ?: 'The Bitter Reality publishes fast, clear explainers on daily trending searches, viral news, technology, business, politics, sports and entertainment.',
            'keywords' => 'trending news, Google Trends, viral topics, latest articles, breaking news, English news',
            'image' => $image ?: asset('images/default-news.svg'),
            'url' => url()->current(),
            'type' => $type,
            'canonical' => url()->current(),
        ];
    }

    public function article(Article $article): array
    {
        return $this->page(
            $article->meta_title ?: $article->title(),
            $article->meta_description ?: $article->excerpt(),
            $article->imageUrl(),
            'article'
        ) + [
            'keywords' => $article->meta_keywords ?: $article->tags->pluck('name')->join(', '),
        ];
    }

    public function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'The Bitter Reality',
            'url' => url('/'),
            'logo' => asset('images/default-news.svg'),
            'sameAs' => [],
        ];
    }

    public function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'The Bitter Reality',
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => route('search').'?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    public function articleSchema(Article $article): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => Str::limit($article->title(), 110, ''),
            'description' => $article->excerpt(),
            'image' => [$article->imageUrl()],
            'datePublished' => $article->published_at?->toAtomString(),
            'dateModified' => $article->updated_at?->toAtomString(),
            'author' => ['@type' => 'Person', 'name' => $article->author?->name ?: 'Editorial Desk'],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'The Bitter Reality',
                'logo' => ['@type' => 'ImageObject', 'url' => asset('images/default-news.svg')],
            ],
            'mainEntityOfPage' => $article->routeUrl(),
        ];
    }

    public function breadcrumbSchema(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($item, $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ])->all(),
        ];
    }
}
