<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HistoricalFigure;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FigureController extends Controller
{
    public function index(Request $request): View
    {
        $figures = HistoricalFigure::published()
            ->with('translations')
            ->when($request->era, fn($q, $era) => $q->where('era', $era))
            ->when($request->category, fn($q, $cat) => $q->where('category', $cat))
            ->orderByDesc('view_count')
            ->paginate(24);

        $eras = HistoricalFigure::published()->distinct()->pluck('era')->filter()->sort()->values();

        return view('public.figures.index', compact('figures', 'eras'));
    }

    public function show(Request $request, string $slug): View
    {
        $figure = HistoricalFigure::published()
            ->where('slug', $slug)
            ->with([
                'translations',
                'topics' => fn($q) => $q->published()->with(['translations', 'category.translations'])->limit(6),
            ])
            ->firstOrFail();

        $figure->increment('view_count');

        $seo = [
            'title'       => ($figure->trans('meta_title') ?: $figure->name()) . ' — The Bitter Reality',
            'description' => $figure->trans('meta_description') ?: $figure->shortBio(),
            'image'       => $figure->imageUrl(),
            'canonical'   => $figure->routeUrl(),
        ];

        return view('public.figures.show', compact('figure', 'seo'));
    }
}
