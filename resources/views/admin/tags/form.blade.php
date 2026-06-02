@extends('layouts.admin')
@section('title', isset($tag) ? 'Edit Tag' : 'New Tag') @section('heading', isset($tag) ? 'Edit Tag' : 'New Tag')
@section('content')
<form method="POST" action="{{ isset($tag) ? route('admin.tags.update', $tag) : route('admin.tags.store') }}" class="max-w-lg space-y-5">
    @csrf @if(isset($tag)) @method('PUT') @endif
    <div><label class="admin-label">Slug</label><input class="input" name="slug" required value="{{ old('slug', $tag?->slug) }}" placeholder="world-war-2"></div>
    <div><label class="admin-label">Name (English) *</label><input class="input" name="en_name" required value="{{ old('en_name', $tag?->trans('name', 'en')) }}"></div>
    <div><label class="admin-label">नाम (Hindi)</label><input class="input" name="hi_name" value="{{ old('hi_name', $tag?->trans('name', 'hi')) }}"></div>
    <div class="flex gap-3">
        <button type="submit" class="rounded-xl bg-amber-400 px-6 py-3 text-sm font-bold text-black">{{ isset($tag) ? 'Save' : 'Create' }}</button>
        <a href="{{ route('admin.tags.index') }}" class="rounded-xl border border-white/10 px-6 py-3 text-sm text-slate-400">Cancel</a>
    </div>
</form>
<style>.admin-label { @apply mb-1.5 block text-xs font-bold uppercase tracking-widest text-slate-600; }</style>
@endsection
