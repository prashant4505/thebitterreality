<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::with('translations')->latest()->paginate(30);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.form', ['tag' => null]);
    }

    public function store(Request $request)
    {
        $request->validate(['slug' => 'required', 'en_name' => 'required']);
        $tag = Tag::create(['slug' => Str::slug($request->slug)]);
        $this->saveTranslations($tag, $request);
        return redirect()->route('admin.tags.index')->with('success', 'Tag created.');
    }

    public function edit(Tag $tag)
    {
        $tag->load('translations');
        return view('admin.tags.form', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate(['en_name' => 'required']);
        $tag->update(['slug' => Str::slug($request->slug ?? $tag->slug)]);
        $this->saveTranslations($tag, $request);
        return redirect()->route('admin.tags.index')->with('success', 'Tag updated.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted.');
    }

    private function saveTranslations(Tag $tag, Request $request): void
    {
        foreach (['en', 'hi'] as $locale) {
            $name = $request->input("{$locale}_name");
            if (!$name) continue;
            $tag->translations()->updateOrCreate(['locale' => $locale], ['name' => $name]);
        }
    }
}
