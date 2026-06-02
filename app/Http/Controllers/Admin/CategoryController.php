<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('translations')->orderBy('sort_order')->paginate(30);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => null]);
    }

    public function store(Request $request)
    {
        $request->validate(['slug' => 'required|string', 'en_name' => 'required|string']);
        $category = Category::create([
            'slug'         => Str::slug($request->slug),
            'accent_color' => $request->accent_color ?? '#06b6d4',
            'icon'         => $request->icon,
            'sort_order'   => $request->sort_order ?? 0,
            'is_active'    => $request->boolean('is_active', true),
        ]);
        $this->saveTranslations($category, $request);
        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        $category->load('translations');
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['en_name' => 'required|string']);
        $category->update([
            'slug'         => Str::slug($request->slug ?? $category->slug),
            'accent_color' => $request->accent_color ?? $category->accent_color,
            'icon'         => $request->icon,
            'sort_order'   => $request->sort_order ?? $category->sort_order,
            'is_active'    => $request->boolean('is_active'),
        ]);
        $this->saveTranslations($category, $request);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }

    private function saveTranslations(Category $category, Request $request): void
    {
        foreach (['en', 'hi'] as $locale) {
            $name = $request->input("{$locale}_name");
            if (!$name) continue;
            $category->translations()->updateOrCreate(['locale' => $locale], [
                'name'             => $name,
                'description'      => $request->input("{$locale}_description"),
                'meta_title'       => $request->input("{$locale}_meta_title"),
                'meta_description' => $request->input("{$locale}_meta_description"),
            ]);
        }
    }
}
