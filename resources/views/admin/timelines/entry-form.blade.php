@extends('layouts.admin')
@section('title', isset($entry) ? 'Edit Entry' : 'New Entry')
@section('heading', isset($entry) ? 'Edit Entry' : 'New Timeline Entry')
@section('content')
<form method="POST"
      action="{{ isset($entry) ? route('admin.entries.update', $entry) : route('admin.timelines.entries.store', $timeline) }}"
      class="ck-tabbed-form grid gap-6 lg:grid-cols-[1fr_260px]">
    @csrf @if(isset($entry)) @method('PUT') @endif

    <div class="space-y-5">
        <div class="ck-tab-bar flex gap-1 rounded-xl border border-white/8 bg-white/[.02] p-1 w-fit">
            <button type="button" class="ck-tab-btn active rounded-lg px-5 py-2 text-sm font-bold transition" data-lang="en">English</button>
            <button type="button" class="ck-tab-btn rounded-lg px-5 py-2 text-sm font-bold transition text-slate-400 hover:text-white" data-lang="hi">हिंदी</button>
        </div>
        <div class="ck-tab-panel space-y-4" data-lang="en">
            <div><label class="admin-label">Title (English) *</label><input class="input" name="en_title" required value="{{ old('en_title', $entry?->trans('title', 'en')) }}"></div>
            <div><label class="admin-label">Description</label><textarea class="input h-24 resize-none" name="en_description">{{ old('en_description', $entry?->trans('description', 'en')) }}</textarea></div>
        </div>
        <div class="ck-tab-panel hidden space-y-4" data-lang="hi">
            <div><label class="admin-label">शीर्षक (Hindi)</label><input class="input" name="hi_title" value="{{ old('hi_title', $entry?->trans('title', 'hi')) }}"></div>
            <div><label class="admin-label">विवरण</label><textarea class="input h-24 resize-none" name="hi_description">{{ old('hi_description', $entry?->trans('description', 'hi')) }}</textarea></div>
        </div>
    </div>

    <div class="space-y-5">
        <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5 space-y-4">
            <div><label class="admin-label">Date Label *</label><input class="input" name="date_label" required value="{{ old('date_label', $entry?->date_label) }}" placeholder="753 BC, 1947, March 15 44 BC"></div>
            <div><label class="admin-label">Sort Order</label><input class="input" type="number" name="sort_order" value="{{ old('sort_order', $entry?->sort_order ?? 1) }}"></div>
            <div>
                <label class="admin-label">Type</label>
                <select class="input" name="type">
                    @foreach(['event','milestone','turning_point','discovery'] as $type)
                    <option value="{{ $type }}" {{ old('type', $entry?->type ?? 'event') === $type ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$type)) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <button type="submit" class="rounded-xl bg-amber-400 py-3 text-sm font-bold text-black hover:bg-amber-300 transition">{{ isset($entry) ? 'Save Entry' : 'Add Entry' }}</button>
            <a href="{{ route('admin.timelines.entries.index', $timeline) }}" class="rounded-xl border border-white/10 py-3 text-center text-sm text-slate-400">Cancel</a>
        </div>
    </div>
</form>
<style>.admin-label { @apply mb-1.5 block text-xs font-bold uppercase tracking-widest text-slate-600; }</style>
@endsection
