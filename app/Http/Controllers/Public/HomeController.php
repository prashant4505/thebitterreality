<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HistoricalFigure;
use App\Models\SearchTrend;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featured = Topic::published()->featured()
            ->with(['translations', 'category.translations'])
            ->latest('published_at')->limit(6)->get();

        $latest = Topic::published()
            ->with(['translations', 'category.translations'])
            ->latest('published_at')->limit(8)->get();

        $trending = Topic::published()
            ->with(['translations', 'category.translations'])
            ->orderByDesc('view_count')->limit(8)->get();

        $figures = HistoricalFigure::published()
            ->with('translations')
            ->orderByDesc('view_count')->limit(6)->get();

        $categories = Category::where('is_active', true)
            ->with('translations')
            ->orderBy('sort_order')->get();

        // Group topics by category for homepage sections
        $byCategory = [];
        foreach ($categories->take(6) as $cat) {
            $topics = Topic::published()
                ->where('category_id', $cat->id)
                ->with(['translations', 'category.translations'])
                ->latest('published_at')->limit(4)->get();
            if ($topics->isNotEmpty()) {
                $byCategory[] = ['category' => $cat, 'topics' => $topics];
            }
        }

        $searchTrends = SearchTrend::orderByDesc('count')->limit(10)->pluck('query');

        return view('public.home', compact(
            'featured', 'latest', 'trending', 'figures', 'categories', 'byCategory', 'searchTrends'
        ));
    }

    public function trending(): View
    {
        $topics = Topic::published()
            ->with(['translations', 'category.translations'])
            ->orderByDesc('view_count')
            ->paginate(20);

        return view('public.topics.index', [
            'topics' => $topics,
            'pageTitle' => 'Trending Topics',
            'seo' => ['title' => 'Trending Topics — The Bitter Reality'],
        ]);
    }

    public function latest(): View
    {
        $topics = Topic::published()
            ->with(['translations', 'category.translations'])
            ->latest('published_at')
            ->paginate(20);

        return view('public.topics.index', [
            'topics' => $topics,
            'pageTitle' => 'Latest Research',
            'seo' => ['title' => 'Latest Research — The Bitter Reality'],
        ]);
    }
}
