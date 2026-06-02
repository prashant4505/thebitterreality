@extends('layouts.admin')
@section('title', isset($chapter) ? 'Edit Chapter' : 'New Chapter')
@section('heading', isset($chapter) ? 'Edit Chapter' : 'Add Chapter — ' . ($topic->trans('title', 'en') ?? $topic->slug))

@section('content')
<form method="POST"
      action="{{ isset($chapter) ? route('admin.chapters.update', $chapter) : route('admin.topics.chapters.store', $topic) }}"
      enctype="multipart/form-data"
      class="ck-tabbed-form">
    @csrf
    @if(isset($chapter)) @method('PUT') @endif

    <div class="grid gap-6 lg:grid-cols-[1fr_280px]">

        {{-- ─── Content ────────────────────────────────── --}}
        <div class="space-y-6">
            {{-- Language tab bar --}}
            <div class="ck-tab-bar flex gap-1 rounded-xl border border-white/8 bg-white/[.02] p-1 w-fit">
                <button type="button" class="ck-tab-btn active rounded-lg px-5 py-2 text-sm font-bold transition" data-lang="en">English</button>
                <button type="button" class="ck-tab-btn rounded-lg px-5 py-2 text-sm font-bold transition text-slate-400 hover:text-white" data-lang="hi">हिंदी</button>
            </div>

            {{-- English panel --}}
            <div class="ck-tab-panel space-y-5" data-lang="en">
                <div>
                    <label class="admin-label">Chapter Title (English) *</label>
                    <input class="input" name="en_title" required value="{{ old('en_title', $chapter?->trans('title', 'en')) }}">
                </div>
                <div>
                    <label class="admin-label">Summary (optional teaser)</label>
                    <textarea class="input h-20 resize-none" name="en_summary">{{ old('en_summary', $chapter?->trans('summary', 'en')) }}</textarea>
                </div>
                <div>
                    <label class="admin-label">Content *</label>
                    <textarea id="en_content" class="input use-ckeditor" name="en_content"
                              style="min-height:500px">{!! old('en_content', $chapter?->trans('content', 'en')) !!}</textarea>
                </div>
                <div>
                    <label class="admin-label">Key Lessons (one per line)</label>
                    <textarea class="input h-28 resize-none font-mono text-xs" name="en_key_lessons_raw"
                              placeholder="Each lesson on its own line">{{ old('en_key_lessons_raw', $chapter ? implode("\n", $chapter->keyLessons()) : '') }}</textarea>
                </div>
            </div>

            {{-- Hindi panel --}}
            <div class="ck-tab-panel hidden space-y-5" data-lang="hi">
                <div>
                    <label class="admin-label">अध्याय शीर्षक (Hindi)</label>
                    <input class="input" name="hi_title" value="{{ old('hi_title', $chapter?->trans('title', 'hi')) }}">
                </div>
                <div>
                    <label class="admin-label">सारांश</label>
                    <textarea class="input h-20 resize-none" name="hi_summary">{{ old('hi_summary', $chapter?->trans('summary', 'hi')) }}</textarea>
                </div>
                <div>
                    <label class="admin-label">सामग्री (Content)</label>
                    <textarea id="hi_content" class="input use-ckeditor" name="hi_content"
                              style="min-height:500px">{!! old('hi_content', $chapter?->trans('content', 'hi')) !!}</textarea>
                </div>
            </div>
        </div>

        {{-- ─── Sidebar ────────────────────────────────── --}}
        <div class="space-y-5">

            {{-- Chapter Image --}}
            <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5 space-y-3">
                <p class="text-xs font-black uppercase tracking-widest text-amber-400">Chapter Image</p>
                @if($chapter?->featured_image)
                <img id="chapterImgPreview" src="{{ asset('storage/' . $chapter->featured_image) }}"
                     alt="Current" class="img-preview w-full">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remove_image" value="1" class="rounded accent-rose-500">
                    <span class="text-xs text-rose-400">Remove current image</span>
                </label>
                @else
                <img id="chapterImgPreview" src="" alt="" class="img-preview w-full hidden">
                @endif
                <label class="block">
                    <span class="admin-label">{{ $chapter?->featured_image ? 'Replace Image' : 'Upload Image' }}</span>
                    <input type="file" name="featured_image" accept="image/*"
                           class="mt-1 block w-full text-xs text-slate-400 file:mr-3 file:rounded-lg file:border-0 file:bg-amber-400 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-black file:cursor-pointer"
                           onchange="previewImage(this,'chapterImgPreview')">
                </label>
                <p class="text-xs text-slate-600">JPG, PNG, WebP · max 5 MB</p>
            </div>

            {{-- Settings --}}
            <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5 space-y-4">
                <p class="text-xs font-black uppercase tracking-widest text-amber-400">Settings</p>
                <div>
                    <label class="admin-label">Sort Order</label>
                    <input class="input" type="number" name="sort_order" min="1"
                           value="{{ old('sort_order', $chapter?->sort_order ?? 1) }}">
                </div>
                <div>
                    <label class="admin-label">Reading Time (min)</label>
                    <input class="input" type="number" name="reading_time" min="1"
                           value="{{ old('reading_time', $chapter?->reading_time ?? 5) }}">
                </div>
                <label class="flex cursor-pointer items-center justify-between">
                    <span class="text-sm text-slate-300">Published</span>
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="rounded"
                           {{ old('is_published', $chapter?->is_published ?? true) ? 'checked' : '' }}>
                </label>
            </div>

            <div class="flex flex-col gap-3">
                <button type="submit" class="rounded-xl bg-amber-400 py-3 text-sm font-bold text-black hover:bg-amber-300 transition">
                    {{ isset($chapter) ? 'Save Chapter' : 'Add Chapter' }}
                </button>
                <a href="{{ route('admin.topics.chapters.index', $topic) }}"
                   class="rounded-xl border border-white/10 py-3 text-center text-sm text-slate-400 hover:text-white transition">Cancel</a>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="mt-5 rounded-2xl border border-rose-400/30 bg-rose-950/25 p-4 text-sm text-rose-300">
        @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
    </div>
    @endif
</form>
<style>.admin-label { @apply mb-1.5 block text-xs font-bold uppercase tracking-widest text-slate-600; }</style>
@endsection
