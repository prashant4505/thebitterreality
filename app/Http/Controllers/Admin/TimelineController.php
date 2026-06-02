<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timeline;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TimelineController extends Controller
{
    public function index()
    {
        $timelines = Timeline::with(['topic.translations'])->latest()->paginate(20);
        return view('admin.timelines.index', compact('timelines'));
    }

    public function create()
    {
        $topics = Topic::with('translations')->orderBy('id')->get();
        return view('admin.timelines.form', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate(['topic_id' => 'required|exists:topics,id', 'slug' => 'required']);
        $timeline = Timeline::create([
            'topic_id'    => $request->topic_id,
            'slug'        => Str::slug($request->slug),
            'is_published'=> $request->boolean('is_published', true),
        ]);
        return redirect()->route('admin.timelines.entries.index', $timeline)
            ->with('success', 'Timeline created. Now add entries.');
    }

    public function edit(Timeline $timeline)
    {
        $timeline->load(['topic.translations', 'entries.translations']);
        $topics = Topic::with('translations')->orderBy('id')->get();
        return view('admin.timelines.form', compact('timeline', 'topics'));
    }

    public function update(Request $request, Timeline $timeline)
    {
        $timeline->update([
            'is_published' => $request->boolean('is_published'),
        ]);
        return redirect()->route('admin.timelines.index')->with('success', 'Timeline updated.');
    }

    public function destroy(Timeline $timeline)
    {
        $timeline->delete();
        return redirect()->route('admin.timelines.index')->with('success', 'Timeline deleted.');
    }
}
