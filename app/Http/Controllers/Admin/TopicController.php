<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HistoricalFigure;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::with(['translations', 'category.translations'])
            ->latest()->paginate(20);
        return view('admin.topics.index', compact('topics'));
    }

    public function create()
    {
        $categories = Category::with('translations')->orderBy('sort_order')->get();
        $figures    = HistoricalFigure::with('translations')->orderBy('id')->get();
        $tags       = Tag::with('translations')->orderBy('id')->get();
        return view('admin.topics.form', compact('categories', 'figures', 'tags') + ['topic' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('featured_image')) {
            $data['topic']['featured_image'] = $request->file('featured_image')->store('uploads/featured', 'public');
        }

        $topic = Topic::create($data['topic']);
        $this->saveTranslations($topic, $request);
        $this->syncRelations($topic, $request);

        return redirect()->route('admin.topics.index')->with('success', 'Topic created successfully.');
    }

    public function edit(Topic $topic)
    {
        $topic->load(['translations', 'tags', 'figures', 'chapters.translations']);
        $categories = Category::with('translations')->orderBy('sort_order')->get();
        $figures    = HistoricalFigure::with('translations')->orderBy('id')->get();
        $tags       = Tag::with('translations')->orderBy('id')->get();
        return view('admin.topics.form', compact('topic', 'categories', 'figures', 'tags'));
    }

    public function update(Request $request, Topic $topic)
    {
        $data = $this->validated($request);

        if ($request->hasFile('featured_image')) {
            if ($topic->featured_image) Storage::disk('public')->delete($topic->featured_image);
            $data['topic']['featured_image'] = $request->file('featured_image')->store('uploads/featured', 'public');
        } elseif ($request->boolean('remove_image') && $topic->featured_image) {
            Storage::disk('public')->delete($topic->featured_image);
            $data['topic']['featured_image'] = null;
        }

        $topic->update($data['topic']);
        $this->saveTranslations($topic, $request);
        $this->syncRelations($topic, $request);

        return redirect()->route('admin.topics.index')->with('success', 'Topic updated successfully.');
    }

    public function show(Topic $topic)
    {
        return redirect()->route('admin.topics.edit', $topic);
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->route('admin.topics.index')->with('success', 'Topic deleted.');
    }

    private function validated(Request $request): array
    {
        $request->validate([
            'slug'           => ['required', 'string', 'max:200'],
            'category_id'    => ['required', 'exists:categories,id'],
            'difficulty'     => ['required', 'in:beginner,intermediate,advanced'],
            'en_title'       => ['required', 'string', 'max:255'],
            'en_excerpt'     => ['nullable', 'string'],
            'en_overview'    => ['nullable', 'string'],
            'hi_title'       => ['nullable', 'string', 'max:255'],
            'hi_excerpt'     => ['nullable', 'string'],
            'hi_overview'    => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
        ]);

        return [
            'topic' => [
                'slug'         => Str::slug($request->slug),
                'category_id'  => $request->category_id,
                'user_id'      => auth()->id(),
                'era'          => $request->era,
                'region'       => $request->region,
                'difficulty'   => $request->difficulty,
                'reading_time' => $request->reading_time ?? 0,
                'is_featured'  => $request->boolean('is_featured'),
                'is_published' => $request->boolean('is_published'),
                'published_at' => $request->boolean('is_published') ? now() : null,
            ],
        ];
    }

    private function saveTranslations(Topic $topic, Request $request): void
    {
        foreach (['en', 'hi'] as $locale) {
            $title = $request->input("{$locale}_title");
            if (!$title) continue;
            $topic->translations()->updateOrCreate(['locale' => $locale], [
                'title'            => $title,
                'subtitle'         => $request->input("{$locale}_subtitle"),
                'excerpt'          => $request->input("{$locale}_excerpt"),
                'overview'         => $request->input("{$locale}_overview"),
                'meta_title'       => $request->input("{$locale}_meta_title"),
                'meta_description' => $request->input("{$locale}_meta_description"),
                'keywords'         => $request->input("{$locale}_keywords"),
            ]);
        }
    }

    private function syncRelations(Topic $topic, Request $request): void
    {
        $topic->tags()->sync($request->input('tags', []));
        $figurePivot = [];
        foreach ($request->input('figures', []) as $figureId => $role) {
            $figurePivot[$figureId] = ['role' => $role];
        }
        $topic->figures()->sync($figurePivot);
    }
}
