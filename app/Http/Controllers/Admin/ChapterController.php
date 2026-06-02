<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChapterController extends Controller
{
    public function index(Topic $topic)
    {
        $topic->load(['chapters' => fn($q) => $q->with('translations')]);
        return view('admin.chapters.index', compact('topic'));
    }

    public function create(Topic $topic)
    {
        return view('admin.chapters.form', ['topic' => $topic, 'chapter' => null]);
    }

    public function store(Request $request, Topic $topic)
    {
        $request->validate([
            'en_title'      => ['required', 'string', 'max:255'],
            'en_content'    => ['required', 'string'],
            'featured_image'=> ['nullable', 'image', 'max:5120'],
        ]);

        $chapterData = [
            'slug'         => Str::slug($request->en_title),
            'sort_order'   => $request->sort_order ?? $topic->chapters()->max('sort_order') + 1,
            'reading_time' => $request->reading_time ?? 5,
            'is_published' => $request->boolean('is_published', true),
        ];

        if ($request->hasFile('featured_image')) {
            $chapterData['featured_image'] = $request->file('featured_image')->store('uploads/featured', 'public');
        }

        $chapter = $topic->chapters()->create($chapterData);
        $this->saveTranslations($chapter, $request);

        return redirect()->route('admin.topics.chapters.index', $topic)
            ->with('success', 'Chapter created.');
    }

    public function edit(Chapter $chapter)
    {
        $chapter->load(['translations', 'topic']);
        return view('admin.chapters.form', ['topic' => $chapter->topic, 'chapter' => $chapter]);
    }

    public function update(Request $request, Chapter $chapter)
    {
        $request->validate([
            'en_title'      => ['required', 'string', 'max:255'],
            'en_content'    => ['required', 'string'],
            'featured_image'=> ['nullable', 'image', 'max:5120'],
        ]);

        $chapterData = [
            'sort_order'   => $request->sort_order ?? $chapter->sort_order,
            'reading_time' => $request->reading_time ?? $chapter->reading_time,
            'is_published' => $request->boolean('is_published'),
        ];

        if ($request->hasFile('featured_image')) {
            if ($chapter->featured_image) Storage::disk('public')->delete($chapter->featured_image);
            $chapterData['featured_image'] = $request->file('featured_image')->store('uploads/featured', 'public');
        } elseif ($request->boolean('remove_image') && $chapter->featured_image) {
            Storage::disk('public')->delete($chapter->featured_image);
            $chapterData['featured_image'] = null;
        }

        $chapter->update($chapterData);
        $this->saveTranslations($chapter, $request);

        return redirect()->route('admin.topics.chapters.index', $chapter->topic_id)
            ->with('success', 'Chapter updated.');
    }

    public function destroy(Chapter $chapter)
    {
        $topicId = $chapter->topic_id;
        if ($chapter->featured_image) Storage::disk('public')->delete($chapter->featured_image);
        $chapter->delete();
        return redirect()->route('admin.topics.chapters.index', $topicId)
            ->with('success', 'Chapter deleted.');
    }

    private function saveTranslations(Chapter $chapter, Request $request): void
    {
        foreach (['en', 'hi'] as $locale) {
            $title = $request->input("{$locale}_title");
            if (!$title) continue;

            // Key lessons entered as one-per-line plain text
            $lessonsRaw = $request->input("{$locale}_key_lessons_raw", '');
            $lessons    = array_values(array_filter(array_map('trim', explode("\n", $lessonsRaw))));

            $chapter->translations()->updateOrCreate(['locale' => $locale], [
                'title'       => $title,
                'content'     => $request->input("{$locale}_content"),
                'summary'     => $request->input("{$locale}_summary"),
                'key_lessons' => $lessons ?: null,
                // pull_quotes, fact_boxes, myths_vs_facts can be added via Source view in CKEditor
                'pull_quotes'    => null,
                'fact_boxes'     => null,
                'myths_vs_facts' => null,
            ]);
        }
    }
}
