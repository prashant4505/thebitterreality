@extends('layouts.admin')
@section('title', isset($topic) ? 'Edit Topic' : 'New Topic')
@section('heading', isset($topic) ? 'Edit Topic' : 'New Topic')

@section('content')
<form method="POST"
      action="{{ isset($topic) ? route('admin.topics.update', $topic) : route('admin.topics.store') }}"
      enctype="multipart/form-data"
      class="ck-tabbed-form">
    @csrf
    @if(isset($topic)) @method('PUT') @endif

    <div class="grid gap-6 lg:grid-cols-[1fr_300px]">

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
                    <label class="admin-label">Title (English) *</label>
                    <input class="input" name="en_title" required value="{{ old('en_title', $topic?->trans('title', 'en')) }}">
                </div>
                <div>
                    <label class="admin-label">Subtitle</label>
                    <input class="input" name="en_subtitle" value="{{ old('en_subtitle', $topic?->trans('subtitle', 'en')) }}">
                </div>
                <div>
                    <label class="admin-label">Excerpt (shown in cards)</label>
                    <textarea class="input h-24 resize-none" name="en_excerpt">{{ old('en_excerpt', $topic?->trans('excerpt', 'en')) }}</textarea>
                </div>
                <div>
                    <label class="admin-label">Overview (intro before chapters)</label>
                    <textarea id="en_overview" class="input use-ckeditor" name="en_overview"
                              style="min-height:350px">{!! old('en_overview', $topic?->trans('overview', 'en')) !!}</textarea>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="admin-label">Meta Title</label>
                        <input class="input" name="en_meta_title" value="{{ old('en_meta_title', $topic?->trans('meta_title', 'en')) }}">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="admin-label">Meta Description</label>
                        <input class="input" name="en_meta_description" value="{{ old('en_meta_description', $topic?->trans('meta_description', 'en')) }}">
                    </div>
                </div>
                <div>
                    <label class="admin-label">Keywords</label>
                    <input class="input" name="en_keywords" value="{{ old('en_keywords', $topic?->trans('keywords', 'en')) }}">
                </div>
            </div>

            {{-- Hindi panel --}}
            <div class="ck-tab-panel hidden space-y-5" data-lang="hi">
                <div>
                    <label class="admin-label">शीर्षक (Title in Hindi)</label>
                    <input class="input" name="hi_title" value="{{ old('hi_title', $topic?->trans('title', 'hi')) }}">
                </div>
                <div>
                    <label class="admin-label">उपशीर्षक (Subtitle)</label>
                    <input class="input" name="hi_subtitle" value="{{ old('hi_subtitle', $topic?->trans('subtitle', 'hi')) }}">
                </div>
                <div>
                    <label class="admin-label">सारांश (Excerpt)</label>
                    <textarea class="input h-24 resize-none" name="hi_excerpt">{{ old('hi_excerpt', $topic?->trans('excerpt', 'hi')) }}</textarea>
                </div>
                <div>
                    <label class="admin-label">परिचय (Overview)</label>
                    <textarea id="hi_overview" class="input use-ckeditor" name="hi_overview"
                              style="min-height:350px">{!! old('hi_overview', $topic?->trans('overview', 'hi')) !!}</textarea>
                </div>
            </div>

            {{-- Figures --}}
            @if($figures->isNotEmpty())
            <div>
                <label class="admin-label">Historical Figures</label>
                <div class="grid gap-2 sm:grid-cols-2">
                    @foreach($figures as $figure)
                    @php $figureRole = $topic && $topic->figures ? $topic->figures->find($figure->id)?->pivot?->role : null; @endphp
                    <div class="flex items-center gap-2 rounded-xl border border-white/8 bg-white/[.02] p-3">
                        <input type="checkbox" name="figures[{{ $figure->id }}]"
                               id="fig{{ $figure->id }}" value="mentioned"
                               class="rounded border-white/20" {{ $figureRole ? 'checked' : '' }}>
                        <label for="fig{{ $figure->id }}" class="flex-1 text-sm text-slate-300">{{ $figure->trans('name', 'en') }}</label>
                        <input type="text" name="figures[{{ $figure->id }}]" placeholder="Role"
                               class="input w-28 py-1.5 text-xs" value="{{ $figureRole }}">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Tags --}}
            @if($tags->isNotEmpty())
            <div>
                <label class="admin-label">Tags</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                    @php $tagSelected = $topic && $topic->tags->contains($tag->id); @endphp
                    <label class="flex cursor-pointer items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-bold transition {{ $tagSelected ? 'border-amber-400/60 bg-amber-950/30 text-amber-300' : 'border-white/10 bg-white/4 text-slate-400' }}">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="sr-only" {{ $tagSelected ? 'checked' : '' }}>
                        {{ $tag->trans('name', 'en') ?? $tag->slug }}
                    </label>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- ─── Sidebar ────────────────────────────────── --}}
        <div class="space-y-5">

            {{-- Featured Image --}}
            <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5 space-y-3">
                <p class="text-xs font-black uppercase tracking-widest text-amber-400">Featured Image</p>
                @if($topic?->featured_image)
                <img id="topicImgPreview" src="{{ asset('storage/' . $topic->featured_image) }}"
                     alt="Current" class="img-preview w-full">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remove_image" value="1" class="rounded accent-rose-500">
                    <span class="text-xs text-rose-400">Remove current image</span>
                </label>
                @else
                <img id="topicImgPreview" src="" alt="" class="img-preview w-full hidden">
                @endif
                <label class="block">
                    <span class="admin-label">{{ $topic?->featured_image ? 'Replace Image' : 'Upload Image' }}</span>
                    <input type="file" name="featured_image" accept="image/*"
                           class="mt-1 block w-full text-xs text-slate-400 file:mr-3 file:rounded-lg file:border-0 file:bg-amber-400 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-black file:cursor-pointer"
                           onchange="previewImage(this,'topicImgPreview')">
                </label>
                <p class="text-xs text-slate-600">JPG, PNG, WebP · max 5 MB</p>
            </div>

            {{-- Publishing --}}
            <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5">
                <p class="mb-4 text-xs font-black uppercase tracking-widest text-amber-400">Publishing</p>
                <div class="space-y-3">
                    <label class="flex cursor-pointer items-center justify-between">
                        <span class="text-sm text-slate-300">Published</span>
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-white/20" {{ old('is_published', $topic?->is_published) ? 'checked' : '' }}>
                    </label>
                    <label class="flex cursor-pointer items-center justify-between">
                        <span class="text-sm text-slate-300">Featured</span>
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1" class="rounded border-white/20" {{ old('is_featured', $topic?->is_featured) ? 'checked' : '' }}>
                    </label>
                </div>
            </div>

            {{-- Details --}}
            <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5 space-y-4">
                <p class="text-xs font-black uppercase tracking-widest text-amber-400">Details</p>
                <div>
                    <label class="admin-label">Slug *</label>
                    <input class="input" name="slug" required value="{{ old('slug', $topic?->slug) }}" placeholder="roman-empire">
                </div>
                <div>
                    <label class="admin-label">Category *</label>
                    <select class="input" name="category_id" required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $topic?->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->trans('name', 'en') ?? $cat->slug }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="admin-label">Difficulty</label>
                    <select class="input" name="difficulty">
                        @foreach(['beginner', 'intermediate', 'advanced'] as $d)
                        <option value="{{ $d }}" {{ old('difficulty', $topic?->difficulty ?? 'intermediate') === $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="admin-label">Era</label>
                    <input class="input" name="era" value="{{ old('era', $topic?->era) }}" placeholder="Ancient, Modern…">
                </div>
                <div>
                    <label class="admin-label">Region</label>
                    <input class="input" name="region" value="{{ old('region', $topic?->region) }}" placeholder="India, Europe…">
                </div>
                <div>
                    <label class="admin-label">Reading Time (min)</label>
                    <input class="input" type="number" name="reading_time" min="1"
                           value="{{ old('reading_time', $topic?->reading_time ?? 10) }}">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 rounded-xl bg-amber-400 py-3 text-sm font-bold text-black hover:bg-amber-300 transition">
                    {{ isset($topic) ? 'Save Changes' : 'Create Topic' }}
                </button>
                <a href="{{ route('admin.topics.index') }}" class="rounded-xl border border-white/10 px-4 py-3 text-sm text-slate-400 hover:text-white transition">Cancel</a>
            </div>

            @if(isset($topic))
            <a href="{{ route('admin.topics.chapters.index', $topic) }}"
               class="block rounded-xl border border-cyan-400/30 bg-cyan-950/20 py-3 text-center text-sm font-bold text-cyan-300 hover:bg-cyan-950/40 transition">
                Manage Chapters ({{ $topic->chapters->count() }}) →
            </a>
            @endif
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
