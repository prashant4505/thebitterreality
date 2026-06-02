<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\TopicView;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TopicController extends Controller
{
    public function index(Request $request): View
    {
        $topics = Topic::published()
            ->with(['translations', 'category.translations'])
            ->when($request->category, fn($q, $cat) => $q->whereHas('category', fn($q) => $q->where('slug', $cat)))
            ->when($request->era, fn($q, $era) => $q->where('era', $era))
            ->when($request->sort === 'views', fn($q) => $q->orderByDesc('view_count'), fn($q) => $q->latest('published_at'))
            ->paginate(20);

        return view('public.topics.index', ['topics' => $topics]);
    }

    public function show(Request $request, string $category, string $slug): View
    {
        $topic = Topic::published()
            ->whereHas('category', fn($q) => $q->where('slug', $category))
            ->where('slug', $slug)
            ->with([
                'translations',
                'category.translations',
                'chapters' => fn($q) => $q->where('is_published', true)->with('translations'),
                'figures.translations',
                'tags.translations',
                'timelines.entries.translations',
                'relatedTopics.translations',
                'relatedTopics.category.translations',
            ])
            ->firstOrFail();

        // Record view
        TopicView::create([
            'topic_id'   => $topic->id,
            'ip_address' => $request->ip(),
            'session_id' => session()->getId(),
            'viewed_at'  => now(),
        ]);
        $topic->increment('view_count');

        $seo = [
            'title'       => ($topic->trans('meta_title') ?: $topic->title()) . ' — The Bitter Reality',
            'description' => $topic->trans('meta_description') ?: $topic->excerpt(),
            'image'       => $topic->imageUrl(),
            'canonical'   => $topic->routeUrl(),
            'type'        => 'article',
        ];

        return view('public.topics.show', compact('topic', 'seo'));
    }
}
