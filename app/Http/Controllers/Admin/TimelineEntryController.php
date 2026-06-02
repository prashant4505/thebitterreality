<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timeline;
use App\Models\TimelineEntry;
use Illuminate\Http\Request;

class TimelineEntryController extends Controller
{
    public function index(Timeline $timeline)
    {
        $timeline->load(['entries' => fn($q) => $q->with('translations'), 'topic.translations']);
        return view('admin.timelines.entries', compact('timeline'));
    }

    public function create(Timeline $timeline)
    {
        return view('admin.timelines.entry-form', compact('timeline'));
    }

    public function store(Request $request, Timeline $timeline)
    {
        $request->validate([
            'date_label' => 'required|string|max:100',
            'en_title'   => 'required|string|max:255',
        ]);

        $entry = $timeline->entries()->create([
            'date_label' => $request->date_label,
            'sort_order' => $request->sort_order ?? $timeline->entries()->max('sort_order') + 1,
            'type'       => $request->type ?? 'event',
        ]);

        $this->saveTranslations($entry, $request);

        return redirect()->route('admin.timelines.entries.index', $timeline)
            ->with('success', 'Entry added.');
    }

    public function edit(TimelineEntry $entry)
    {
        $entry->load(['translations', 'timeline.topic.translations']);
        return view('admin.timelines.entry-form', ['timeline' => $entry->timeline, 'entry' => $entry]);
    }

    public function update(Request $request, TimelineEntry $entry)
    {
        $request->validate(['en_title' => 'required|string|max:255']);
        $entry->update([
            'date_label' => $request->date_label ?? $entry->date_label,
            'sort_order' => $request->sort_order ?? $entry->sort_order,
            'type'       => $request->type ?? $entry->type,
        ]);
        $this->saveTranslations($entry, $request);
        return redirect()->route('admin.timelines.entries.index', $entry->timeline_id)
            ->with('success', 'Entry updated.');
    }

    public function destroy(TimelineEntry $entry)
    {
        $timelineId = $entry->timeline_id;
        $entry->delete();
        return redirect()->route('admin.timelines.entries.index', $timelineId)
            ->with('success', 'Entry deleted.');
    }

    private function saveTranslations(TimelineEntry $entry, Request $request): void
    {
        foreach (['en', 'hi'] as $locale) {
            $title = $request->input("{$locale}_title");
            if (!$title) continue;
            $entry->translations()->updateOrCreate(['locale' => $locale], [
                'title'       => $title,
                'description' => $request->input("{$locale}_description"),
            ]);
        }
    }
}
