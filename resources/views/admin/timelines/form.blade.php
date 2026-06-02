@extends('layouts.admin')
@section('title', isset($timeline) ? 'Edit Timeline' : 'New Timeline') @section('heading', isset($timeline) ? 'Edit Timeline' : 'New Timeline')
@section('content')
<form method="POST" action="{{ isset($timeline) ? route('admin.timelines.update', $timeline) : route('admin.timelines.store') }}" class="max-w-lg space-y-5">
    @csrf @if(isset($timeline)) @method('PUT') @endif
    <div>
        <label class="admin-label">Topic *</label>
        <select class="input" name="topic_id" required>
            @foreach($topics as $topic)
            <option value="{{ $topic->id }}" {{ old('topic_id', $timeline?->topic_id) == $topic->id ? 'selected' : '' }}>{{ $topic->trans('title', 'en') ?? $topic->slug }}</option>
            @endforeach
        </select>
    </div>
    <div><label class="admin-label">Slug</label><input class="input" name="slug" value="{{ old('slug', $timeline?->slug) }}" placeholder="roman-empire-timeline"></div>
    <label class="flex cursor-pointer items-center justify-between">
        <span class="text-sm text-slate-300">Published</span>
        <input type="hidden" name="is_published" value="0">
        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $timeline?->is_published ?? true) ? 'checked' : '' }}>
    </label>
    <div class="flex gap-3">
        <button type="submit" class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-black">{{ isset($timeline) ? 'Save' : 'Create' }}</button>
        <a href="{{ route('admin.timelines.index') }}" class="rounded-xl border border-white/10 px-6 py-3 text-sm text-slate-400">Cancel</a>
    </div>
</form>
<style>.admin-label { @apply mb-1.5 block text-xs font-bold uppercase tracking-widest text-slate-600; }</style>
@endsection
