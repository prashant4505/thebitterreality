<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HistoricalFigure;
use App\Models\Topic;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function xml(): Response
    {
        $topics = Topic::published()->with(['translations', 'category'])->get();
        $figures = HistoricalFigure::published()->get();

        return response()->view('public.sitemap-xml', compact('topics', 'figures'))
            ->header('Content-Type', 'text/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nSitemap: " . url('/sitemap.xml');
        return response($content)->header('Content-Type', 'text/plain');
    }
}
