<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StaticPageController extends Controller
{
    public function index()
    {
        $pages = StaticPage::with('translations')->latest()->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.form', ['page' => null]);
    }

    public function store(Request $request)
    {
        $request->validate(['slug' => 'required', 'en_title' => 'required', 'en_content' => 'required']);
        $page = StaticPage::create(['slug' => Str::slug($request->slug), 'is_published' => $request->boolean('is_published', true)]);
        $this->saveTranslations($page, $request);
        return redirect()->route('admin.pages.index')->with('success', 'Page created.');
    }

    public function edit(StaticPage $page)
    {
        $page->load('translations');
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, StaticPage $page)
    {
        $request->validate(['en_title' => 'required', 'en_content' => 'required']);
        $page->update(['is_published' => $request->boolean('is_published')]);
        $this->saveTranslations($page, $request);
        return redirect()->route('admin.pages.index')->with('success', 'Page updated.');
    }

    public function destroy(StaticPage $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }

    private function saveTranslations(StaticPage $page, Request $request): void
    {
        foreach (['en', 'hi'] as $locale) {
            $title = $request->input("{$locale}_title");
            if (!$title) continue;
            $page->translations()->updateOrCreate(['locale' => $locale], [
                'title'            => $title,
                'content'          => $request->input("{$locale}_content"),
                'meta_title'       => $request->input("{$locale}_meta_title"),
                'meta_description' => $request->input("{$locale}_meta_description"),
            ]);
        }
    }
}
