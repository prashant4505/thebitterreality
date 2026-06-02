@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Category' : 'New Category')
@section('heading', isset($category) ? 'Edit Category' : 'New Category')
@section('content')
<form method="POST"
      action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
      class="ck-tabbed-form">
    @csrf @if(isset($category)) @method('PUT') @endif

    <div class="grid gap-6 lg:grid-cols-[1fr_260px]">
        <div class="space-y-5">
            <div class="ck-tab-bar flex gap-1 rounded-xl border border-white/8 bg-white/[.02] p-1 w-fit">
                <button type="button" class="ck-tab-btn active rounded-lg px-5 py-2 text-sm font-bold transition" data-lang="en">English</button>
                <button type="button" class="ck-tab-btn rounded-lg px-5 py-2 text-sm font-bold transition text-slate-400 hover:text-white" data-lang="hi">हिंदी</button>
            </div>
            <div class="ck-tab-panel space-y-4" data-lang="en">
                <div><label class="admin-label">Name (English) *</label><input class="input" name="en_name" required value="{{ old('en_name', $category?->trans('name', 'en')) }}"></div>
                <div><label class="admin-label">Description</label><textarea class="input h-20 resize-none" name="en_description">{{ old('en_description', $category?->trans('description', 'en')) }}</textarea></div>
            </div>
            <div class="ck-tab-panel hidden space-y-4" data-lang="hi">
                <div><label class="admin-label">नाम (Hindi)</label><input class="input" name="hi_name" value="{{ old('hi_name', $category?->trans('name', 'hi')) }}"></div>
                <div><label class="admin-label">विवरण</label><textarea class="input h-20 resize-none" name="hi_description">{{ old('hi_description', $category?->trans('description', 'hi')) }}</textarea></div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5 space-y-4">
                <p class="text-xs font-black uppercase tracking-widest text-amber-400">Settings</p>
                <div><label class="admin-label">Slug</label><input class="input" name="slug" value="{{ old('slug', $category?->slug) }}" placeholder="history"></div>
                <div><label class="admin-label">Accent Color</label><input class="input" type="color" name="accent_color" value="{{ old('accent_color', $category?->accent_color ?? '#f59e0b') }}"></div>
                <div><label class="admin-label">Sort Order</label><input class="input" type="number" name="sort_order" value="{{ old('sort_order', $category?->sort_order ?? 0) }}"></div>
                <label class="flex cursor-pointer items-center justify-between">
                    <span class="text-sm text-slate-300">Active</span>
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category?->is_active ?? true) ? 'checked' : '' }}>
                </label>
            </div>
            <div class="flex flex-col gap-3">
                <button type="submit" class="rounded-xl bg-amber-400 py-3 text-sm font-bold text-black hover:bg-amber-300 transition">{{ isset($category) ? 'Save' : 'Create' }}</button>
                <a href="{{ route('admin.categories.index') }}" class="rounded-xl border border-white/10 py-3 text-center text-sm text-slate-400">Cancel</a>
            </div>
        </div>
    </div>
</form>
<style>.admin-label { @apply mb-1.5 block text-xs font-bold uppercase tracking-widest text-slate-600; }</style>
@endsection
