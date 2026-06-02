<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\StaticPage;
use App\Models\Topic;
use Illuminate\View\View;

class StaticPageController extends Controller
{
    public function show(string $slug): View
    {
        $page = StaticPage::where('slug', $slug)->where('is_published', true)
            ->with('translations')->firstOrFail();

        $seo = [
            'title'       => $page->title() . ' — The Bitter Reality',
            'description' => $page->trans('meta_description'),
            'canonical'   => url()->current(),
        ];

        return view('public.page', compact('page', 'seo'));
    }

    public function sitemap(): View
    {
        $topics = Topic::published()->with(['translations', 'category'])->get();
        return view('public.sitemap', compact('topics'));
    }
}
