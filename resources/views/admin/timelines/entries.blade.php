@extends('layouts.admin')
@section('title','Timeline Entries') @section('heading','Timeline Entries — ' . ($timeline->topic?->trans('title', 'en') ?? $timeline->slug))
@section('content')
<div class="mb-5 flex items-center justify-between">
    <a href="{{ route('admin.timelines.index') }}" class="text-sm text-slate-500 hover:text-amber-400">← Back to Timelines</a>
    <a href="{{ route('admin.timelines.entries.create', $timeline) }}" class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-bold text-black">+ Add Entry</a>
</div>
<div class="space-y-3">
    @forelse($timeline->entries as $entry)
    <div class="flex items-start gap-4 rounded-2xl border border-white/8 bg-white/[.02] p-4">
        <span class="mt-1 flex-shrink-0 rounded-full bg-amber-950/50 px-3 py-1 text-xs font-black text-amber-400">{{ $entry->date_label }}</span>
        <div class="flex-1">
            <p class="font-bold text-white">{{ $entry->trans('title', 'en') }}</p>
            @if($entry->trans('title', 'hi')) <p class="text-xs text-slate-600">HI: {{ $entry->trans('title', 'hi') }}</p> @endif
            @if($entry->trans('description', 'en')) <p class="mt-1 text-xs text-slate-500 line-clamp-2">{{ $entry->trans('description', 'en') }}</p> @endif
        </div>
        <span class="text-xs text-slate-600 uppercase">{{ $entry->type }}</span>
        <div class="flex gap-3">
            <a href="{{ route('admin.entries.edit', $entry) }}" class="text-xs text-amber-400 hover:text-amber-300">Edit</a>
            <form method="POST" action="{{ route('admin.entries.destroy', $entry) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-xs text-rose-500">Delete</button></form>
        </div>
    </div>
    @empty
    <p class="py-12 text-center text-slate-600">No entries yet.</p>
    @endforelse
</div>
@endsection
