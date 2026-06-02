@extends('layouts.admin')
@section('title', isset($page) ? 'Edit Page' : 'New Page')
@section('heading', isset($page) ? 'Edit Page' : 'New Static Page')

@section('content')
<form method="POST"
      action="{{ isset($page) ? route('admin.pages.update', $page) : route('admin.pages.store') }}"
      class="ck-tabbed-form">
    @csrf @if(isset($page)) @method('PUT') @endif

    <div class="grid gap-6 lg:grid-cols-[1fr_260px]">
        <div class="space-y-5">
            {{-- Language tab bar --}}
            <div class="ck-tab-bar flex gap-1 rounded-xl border border-white/8 bg-white/[.02] p-1 w-fit">
                <button type="button" class="ck-tab-btn active rounded-lg px-5 py-2 text-sm font-bold transition" data-lang="en">English</button>
                <button type="button" class="ck-tab-btn rounded-lg px-5 py-2 text-sm font-bold transition text-slate-400 hover:text-white" data-lang="hi">हिंदी</button>
            </div>

            {{-- English panel --}}
            <div class="ck-tab-panel space-y-4" data-lang="en">
                <div>
                    <label class="admin-label">Title (English) *</label>
                    <input class="input" name="en_title" required value="{{ old('en_title', $page?->trans('title', 'en')) }}">
                </div>
                <div>
                    <label class="admin-label">Content *</label>
                    <textarea id="en_page_content" class="input use-ckeditor" name="en_content"
                              style="min-height:400px">{!! old('en_content', $page?->trans('content', 'en')) !!}</textarea>
                </div>
            </div>

            {{-- Hindi panel --}}
            <div class="ck-tab-panel hidden space-y-4" data-lang="hi">
                <div>
                    <label class="admin-label">शीर्षक (Hindi)</label>
                    <input class="input" name="hi_title" value="{{ old('hi_title', $page?->trans('title', 'hi')) }}">
                </div>
                <div>
                    <label class="admin-label">सामग्री</label>
                    <textarea id="hi_page_content" class="input use-ckeditor" name="hi_content"
                              style="min-height:400px">{!! old('hi_content', $page?->trans('content', 'hi')) !!}</textarea>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5 space-y-4">
                <div>
                    <label class="admin-label">Slug</label>
                    <input class="input" name="slug" value="{{ old('slug', $page?->slug) }}" placeholder="about-us">
                </div>
                <label class="flex cursor-pointer items-center justify-between">
                    <span class="text-sm text-slate-300">Published</span>
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1"
                           {{ old('is_published', $page?->is_published ?? true) ? 'checked' : '' }}>
                </label>
            </div>
            <div class="flex flex-col gap-3">
                <button type="submit" class="rounded-xl bg-amber-400 py-3 text-sm font-bold text-black hover:bg-amber-300 transition">{{ isset($page) ? 'Save' : 'Create' }}</button>
                <a href="{{ route('admin.pages.index') }}" class="rounded-xl border border-white/10 py-3 text-center text-sm text-slate-400 hover:text-white transition">Cancel</a>
            </div>
        </div>
    </div>
</form>
<style>.admin-label { @apply mb-1.5 block text-xs font-bold uppercase tracking-widest text-slate-600; }</style>
@endsection
