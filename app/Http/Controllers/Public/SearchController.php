<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HistoricalFigure;
use App\Models\SearchTrend;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim($request->input('q', ''));

        $topics = collect();
        $figures = collect();

        if ($q) {
            SearchTrend::record($q);

            $topics = Topic::published()
                ->whereHas('translations', function ($query) use ($q) {
                    $query->where('title', 'like', "%{$q}%")
                        ->orWhere('excerpt', 'like', "%{$q}%");
                })
                ->with(['translations', 'category.translations'])
                ->latest('published_at')
                ->limit(20)->get();

            $figures = HistoricalFigure::published()
                ->whereHas('translations', function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('short_bio', 'like', "%{$q}%");
                })
                ->with('translations')
                ->limit(8)->get();
        }

        $trending = SearchTrend::orderByDesc('count')->limit(8)->pluck('query');

        return view('public.search', compact('q', 'topics', 'figures', 'trending'));
    }

    public function suggestions(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $topics = Topic::published()
            ->whereHas('translations', fn($query) => $query->where('title', 'like', "%{$q}%"))
            ->with('translations')
            ->limit(5)->get()
            ->map(fn($t) => ['type' => 'topic', 'label' => $t->title(), 'url' => $t->routeUrl()]);

        $figures = HistoricalFigure::published()
            ->whereHas('translations', fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->with('translations')
            ->limit(3)->get()
            ->map(fn($f) => ['type' => 'figure', 'label' => $f->name(), 'url' => $f->routeUrl()]);

        return response()->json($topics->merge($figures)->values());
    }
}
