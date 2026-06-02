<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)->where('is_active', true)
            ->with('translations')
            ->firstOrFail();

        $topics = $category->topics()
            ->published()
            ->with(['translations', 'category.translations'])
            ->latest('published_at')
            ->paginate(20);

        $seo = [
            'title'       => $category->name() . ' — The Bitter Reality',
            'description' => $category->description(),
            'canonical'   => $category->routeUrl(),
        ];

        return view('public.category.show', compact('category', 'topics', 'seo'));
    }
}
