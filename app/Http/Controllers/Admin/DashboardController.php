<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\HistoricalFigure;
use App\Models\Tag;
use App\Models\Topic;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'totalTopics'    => Topic::count(),
            'publishedTopics'=> Topic::where('is_published', true)->count(),
            'totalFigures'   => HistoricalFigure::count(),
            'totalCategories'=> Category::count(),
            'totalComments'  => Comment::count(),
            'pendingComments'=> Comment::where('is_approved', false)->count(),
            'totalTags'      => Tag::count(),
            'recentTopics'   => Topic::with(['translations', 'category.translations'])
                ->latest()->take(8)->get(),
            'topViewed'      => Topic::with(['translations', 'category.translations'])
                ->orderByDesc('view_count')->take(5)->get(),
        ]);
    }
}
