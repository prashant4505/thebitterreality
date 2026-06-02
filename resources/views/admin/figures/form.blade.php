@extends('layouts.admin')
@section('title', isset($figure) ? 'Edit Figure' : 'New Figure')
@section('heading', isset($figure) ? 'Edit Figure' : 'New Historical Figure')

@section('content')
<form method="POST"
      action="{{ isset($figure) ? route('admin.figures.update', $figure) : route('admin.figures.store') }}"
      enctype="multipart/form-data"
      class="ck-tabbed-form">
    @csrf
    @if(isset($figure)) @method('PUT') @endif

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
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="admin-label">Name (English) *</label>
                        <input class="input" name="en_name" required value="{{ old('en_name', $figure?->trans('name', 'en')) }}">
                    </div>
                    <div>
                        <label class="admin-label">Title / Role</label>
                        <input class="input" name="en_title" placeholder="Emperor, Philosopher…"
                               value="{{ old('en_title', $figure?->trans('title', 'en')) }}">
                    </div>
                </div>
                <div>
                    <label class="admin-label">Short Bio (shown in cards)</label>
                    <textarea class="input h-24 resize-none" name="en_short_bio">{{ old('en_short_bio', $figure?->trans('short_bio', 'en')) }}</textarea>
                </div>
                <div>
                    <label class="admin-label">Full Biography</label>
                    <textarea id="en_full_bio" class="input use-ckeditor" name="en_full_bio"
                              style="min-height:380px">{!! old('en_full_bio', $figure?->trans('full_bio', 'en')) !!}</textarea>
                </div>
                <div>
                    <label class="admin-label">Achievements</label>
                    <textarea id="en_achievements" class="input use-ckeditor" name="en_achievements"
                              style="min-height:260px">{!! old('en_achievements', $figure?->trans('achievements', 'en')) !!}</textarea>
                </div>
                <div>
                    <label class="admin-label">Quotes (one per line)</label>
                    <textarea class="input h-28 resize-none font-mono text-xs" name="en_quotes_raw"
                              placeholder="One quote per line">{{ old('en_quotes_raw', $figure ? implode("\n", $figure->quotes()) : '') }}</textarea>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="admin-label">Meta Title</label>
                        <input class="input" name="en_meta_title" value="{{ old('en_meta_title', $figure?->trans('meta_title', 'en')) }}">
                    </div>
                    <div>
                        <label class="admin-label">Meta Description</label>
                        <input class="input" name="en_meta_description" value="{{ old('en_meta_description', $figure?->trans('meta_description', 'en')) }}">
                    </div>
                </div>
            </div>

            {{-- Hindi panel --}}
            <div class="ck-tab-panel hidden space-y-5" data-lang="hi">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="admin-label">नाम (Hindi)</label>
                        <input class="input" name="hi_name" value="{{ old('hi_name', $figure?->trans('name', 'hi')) }}">
                    </div>
                    <div>
                        <label class="admin-label">उपाधि</label>
                        <input class="input" name="hi_title" value="{{ old('hi_title', $figure?->trans('title', 'hi')) }}">
                    </div>
                </div>
                <div>
                    <label class="admin-label">संक्षिप्त जीवनी</label>
                    <textarea class="input h-24 resize-none" name="hi_short_bio">{{ old('hi_short_bio', $figure?->trans('short_bio', 'hi')) }}</textarea>
                </div>
                <div>
                    <label class="admin-label">पूर्ण जीवनी</label>
                    <textarea id="hi_full_bio" class="input use-ckeditor" name="hi_full_bio"
                              style="min-height:380px">{!! old('hi_full_bio', $figure?->trans('full_bio', 'hi')) !!}</textarea>
                </div>
                <div>
                    <label class="admin-label">उपलब्धियाँ</label>
                    <textarea id="hi_achievements" class="input use-ckeditor" name="hi_achievements"
                              style="min-height:260px">{!! old('hi_achievements', $figure?->trans('achievements', 'hi')) !!}</textarea>
                </div>
            </div>
        </div>

        {{-- ─── Sidebar ────────────────────────────────── --}}
        <div class="space-y-5">

            {{-- Profile Image --}}
            <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5 space-y-3">
                <p class="text-xs font-black uppercase tracking-widest text-amber-400">Profile Image</p>
                @if($figure?->featured_image)
                <img id="figureImgPreview" src="{{ asset('storage/' . $figure->featured_image) }}"
                     alt="Current" class="img-preview w-full">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remove_image" value="1" class="rounded accent-rose-500">
                    <span class="text-xs text-rose-400">Remove current image</span>
                </label>
                @else
                <img id="figureImgPreview" src="" alt="" class="img-preview w-full hidden">
                @endif
                <label class="block">
                    <span class="admin-label">{{ $figure?->featured_image ? 'Replace Image' : 'Upload Image' }}</span>
                    <input type="file" name="featured_image" accept="image/*"
                           class="mt-1 block w-full text-xs text-slate-400 file:mr-3 file:rounded-lg file:border-0 file:bg-amber-400 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-black file:cursor-pointer"
                           onchange="previewImage(this,'figureImgPreview')">
                </label>
                <p class="text-xs text-slate-600">JPG, PNG, WebP · max 5 MB</p>
            </div>

            {{-- Metadata --}}
            <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5 space-y-4">
                <p class="text-xs font-black uppercase tracking-widest text-amber-400">Details</p>
                <div>
                    <label class="admin-label">Slug *</label>
                    <input class="input" name="slug" required value="{{ old('slug', $figure?->slug) }}" placeholder="julius-caesar">
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label class="admin-label">Born</label>
                        <input class="input" name="born" value="{{ old('born', $figure?->born) }}" placeholder="100 BC">
                    </div>
                    <div>
                        <label class="admin-label">Died</label>
                        <input class="input" name="died" value="{{ old('died', $figure?->died) }}" placeholder="44 BC">
                    </div>
                </div>
                <div>
                    <label class="admin-label">Era</label>
                    <input class="input" name="era" value="{{ old('era', $figure?->era) }}" placeholder="Ancient Rome">
                </div>
                <div>
                    <label class="admin-label">Region</label>
                    <input class="input" name="region" value="{{ old('region', $figure?->region) }}" placeholder="Italy / Rome">
                </div>
                <div>
                    <label class="admin-label">Category</label>
                    <input class="input" name="category" value="{{ old('category', $figure?->category) }}" placeholder="Statesman, Philosopher…">
                </div>
                <label class="flex cursor-pointer items-center justify-between">
                    <span class="text-sm text-slate-300">Published</span>
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="rounded"
                           {{ old('is_published', $figure?->is_published ?? true) ? 'checked' : '' }}>
                </label>
            </div>

            <div class="flex flex-col gap-3">
                <button type="submit" class="rounded-xl bg-amber-400 py-3 text-sm font-bold text-black hover:bg-amber-300 transition">
                    {{ isset($figure) ? 'Save Changes' : 'Create Figure' }}
                </button>
                <a href="{{ route('admin.figures.index') }}"
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
