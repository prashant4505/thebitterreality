@extends('layouts.public')

@section('content')

{{-- ═══ HERO ══════════════════════════════════════════════════ --}}
<section class="relative min-h-[90vh] overflow-hidden flex items-center">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_30%_50%,rgba(180,120,20,.12),transparent_60%),radial-gradient(ellipse_at_80%_30%,rgba(16,60,100,.15),transparent_50%)]"></div>

    <div class="container-page relative z-10 py-20 lg:py-28">
        <div class="max-w-4xl">
            <p class="kicker">The Bitter Reality Knowledge Library</p>
            <h1 class="page-title mt-5">Learn the complete story<br><span class="text-amber-400">behind everything.</span></h1>
            <p class="mt-6 max-w-2xl text-xl leading-8 text-slate-400">History. Science. Civilizations. Biographies. Philosophy. Every topic explained like a documentary — with context, causes, consequences, and truth.</p>

            {{-- Search --}}
            <form action="{{ app()->getLocale() === 'hi' ? route('hi.search') : route('search') }}"
                  class="mt-10 flex max-w-2xl flex-col gap-3 sm:flex-row"
                  x-data="{ suggestions: [], q: '', showSug: false }"
                  @submit.prevent="window.location = '{{ app()->getLocale() === 'hi' ? route('hi.search') : route('search') }}?q=' + encodeURIComponent(q)">
                <div class="relative flex-1">
                    <input class="input w-full" name="q" x-model="q"
                           placeholder="Search: Roman Empire, Tesla, Mahabharata, Cold War..."
                           @input.debounce.300ms="if(q.length>1){ fetch('{{ route('search.suggestions') }}?q='+encodeURIComponent(q)).then(r=>r.json()).then(d=>{suggestions=d;showSug=d.length>0}) } else showSug=false"
                           @focus="if(suggestions.length) showSug=true"
                           @blur.200ms="showSug=false">
                    <div x-show="showSug" x-cloak class="absolute top-full left-0 right-0 z-50 mt-1 rounded-2xl border border-white/10 bg-[#06080f] shadow-2xl overflow-hidden">
                        <template x-for="s in suggestions" :key="s.url">
                            <a :href="s.url" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-300 transition hover:bg-white/5 hover:text-amber-300">
                                <span class="rounded px-1.5 py-0.5 text-xs font-bold uppercase" :class="s.type==='topic' ? 'bg-amber-950/60 text-amber-400' : 'bg-cyan-950/60 text-cyan-400'" x-text="s.type"></span>
                                <span x-text="s.label"></span>
                            </a>
                        </template>
                    </div>
                </div>
                <button type="submit" class="btn-primary">Search</button>
            </form>

            {{-- Trending search terms --}}
            @if($searchTrends->isNotEmpty())
            <div class="mt-5 flex flex-wrap items-center gap-2">
                <span class="text-xs text-slate-600 uppercase tracking-widest">Trending:</span>
                @foreach($searchTrends->take(6) as $trend)
                    <a href="{{ (app()->getLocale() === 'hi' ? route('hi.search') : route('search')) . '?q=' . urlencode($trend) }}"
                       class="rounded-full border border-white/10 bg-white/4 px-3 py-1 text-xs text-slate-400 transition hover:border-amber-400/40 hover:text-amber-300">
                        {{ $trend }}
                    </a>
                @endforeach
            </div>
            @endif

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ app()->getLocale() === 'hi' ? route('hi.topics.index') : route('topics.index') }}" class="btn-primary">Explore Topics</a>
                <a href="{{ app()->getLocale() === 'hi' ? route('hi.figures.index') : route('figures.index') }}" class="btn-ghost">Historical Figures</a>
            </div>
        </div>
    </div>

    {{-- Decorative stat strip --}}
    <div class="absolute bottom-0 left-0 right-0 border-t border-white/6 bg-black/30 backdrop-blur-sm">
        <div class="container-page flex flex-wrap divide-x divide-white/8 py-4">
            @foreach([['History', 'Civilizations & Empires'], ['Science', 'Discoveries & Theories'], ['Business', 'Case Studies & Failures'], ['Philosophy', 'Ideas & Religions']] as [$title, $sub])
            <div class="flex-1 px-6 py-1 min-w-[120px]">
                <p class="text-xs font-black uppercase tracking-widest text-amber-400">{{ $title }}</p>
                <p class="mt-0.5 text-xs text-slate-500">{{ $sub }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ FEATURED TOPICS ══════════════════════════════════════════ --}}
@if($featured->isNotEmpty())
<section class="container-page py-16">
    <div class="mb-8 flex items-end justify-between">
        <div>
            <p class="kicker">Editor's Selection</p>
            <h2 class="section-title mt-2">Featured Topics</h2>
        </div>
        <a href="{{ app()->getLocale() === 'hi' ? route('hi.topics.index') : route('topics.index') }}" class="text-sm font-bold uppercase tracking-widest text-amber-400 transition hover:text-amber-300">View All →</a>
    </div>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($featured->take(6) as $i => $topic)
        <a href="{{ $topic->routeUrl() }}" class="knowledge-card-lg group overflow-hidden {{ $i === 0 ? 'md:col-span-2 lg:col-span-2' : '' }}">
            @if($topic->featured_image)
            <div class="overflow-hidden {{ $i === 0 ? 'h-72' : 'h-48' }}">
                <img src="{{ $topic->imageUrl() }}" alt="{{ $topic->title() }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
            </div>
            @endif
            <div class="p-6">
                <div class="flex items-center gap-2">
                    @if($topic->category)
                    <span class="badge-category" style="border-color:{{ $topic->category->accent_color }}40; color:{{ $topic->category->accent_color }}">{{ $topic->category->name() }}</span>
                    @endif
                    @if($topic->era) <span class="badge-era">{{ $topic->era }}</span> @endif
                </div>
                <h3 class="mt-3 text-xl font-bold text-white leading-snug transition group-hover:text-amber-300 {{ $i === 0 ? 'text-2xl' : '' }}">{{ $topic->title() }}</h3>
                @if($topic->excerpt())
                <p class="mt-3 text-sm leading-6 text-slate-400 line-clamp-2">{{ $topic->excerpt() }}</p>
                @endif
                <div class="mt-4 flex items-center gap-4 text-xs text-slate-600">
                    <span>{{ $topic->reading_time }} min read</span>
                    <span>{{ number_format($topic->view_count) }} views</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- ═══ HISTORICAL FIGURES ════════════════════════════════════════ --}}
@if($figures->isNotEmpty())
<section class="border-y border-white/6 bg-white/[.015] py-14">
    <div class="container-page">
        <div class="mb-8 flex items-end justify-between">
            <div>
                <p class="kicker">Profiles</p>
                <h2 class="section-title mt-2">Famous Historical Figures</h2>
            </div>
            <a href="{{ app()->getLocale() === 'hi' ? route('hi.figures.index') : route('figures.index') }}" class="text-sm font-bold uppercase tracking-widest text-amber-400 hover:text-amber-300">All Figures →</a>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($figures as $figure)
            <a href="{{ $figure->routeUrl() }}" class="knowledge-card group flex gap-4 p-5 overflow-hidden">
                <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-2xl">
                    <img src="{{ $figure->imageUrl() }}" alt="{{ $figure->name() }}" class="h-full w-full object-cover transition group-hover:scale-105">
                </div>
                <div class="min-w-0">
                    @if($figure->era) <p class="text-xs font-bold uppercase tracking-widest text-amber-400">{{ $figure->era }}</p> @endif
                    <h3 class="mt-1 font-bold text-white transition group-hover:text-amber-300">{{ $figure->name() }}</h3>
                    @if($figure->title()) <p class="text-xs text-slate-500">{{ $figure->title() }}</p> @endif
                    @if($figure->shortBio()) <p class="mt-2 text-xs leading-5 text-slate-400 line-clamp-2">{{ $figure->shortBio() }}</p> @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══ TRENDING TOPICS ════════════════════════════════════════ --}}
@if($trending->isNotEmpty())
<section class="container-page py-16">
    <div class="mb-8 flex items-end justify-between">
        <div>
            <p class="kicker">Most Read</p>
            <h2 class="section-title mt-2">Trending Topics</h2>
        </div>
        <a href="{{ app()->getLocale() === 'hi' ? route('hi.trending') : route('trending') }}" class="text-sm font-bold uppercase tracking-widest text-amber-400 hover:text-amber-300">View All →</a>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($trending->take(8) as $idx => $topic)
        @include('public.partials.topic-card', ['topic' => $topic, 'index' => $idx + 1])
        @endforeach
    </div>
</section>
@endif

{{-- ═══ CATEGORY SECTIONS ═════════════════════════════════════ --}}
@foreach($byCategory as $section)
<section class="container-page py-12">
    <div class="mb-7 flex items-end justify-between">
        <div>
            <p class="kicker">{{ $section['category']->name() }}</p>
            <h2 class="mt-1 text-2xl font-bold text-white">{{ $section['category']->description() ?? 'Deep dives & research' }}</h2>
        </div>
        <a href="{{ $section['category']->routeUrl() }}" class="text-sm font-bold uppercase tracking-widest text-amber-400 hover:text-amber-300">Explore →</a>
    </div>
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($section['topics'] as $topic)
        @include('public.partials.topic-card', ['topic' => $topic])
        @endforeach
    </div>
</section>
@if(!$loop->last)
<div class="border-t border-white/6"></div>
@endif
@endforeach

{{-- ═══ LATEST RESEARCH ════════════════════════════════════════ --}}
@if($latest->isNotEmpty())
<section class="border-t border-white/6 bg-white/[.012] py-16">
    <div class="container-page">
        <div class="mb-8 flex items-end justify-between">
            <div>
                <p class="kicker">Fresh Knowledge</p>
                <h2 class="section-title mt-2">Latest Research</h2>
            </div>
            <a href="{{ app()->getLocale() === 'hi' ? route('hi.latest') : route('latest') }}" class="text-sm font-bold uppercase tracking-widest text-amber-400 hover:text-amber-300">View All →</a>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($latest->take(8) as $topic)
            @include('public.partials.topic-card', ['topic' => $topic])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══ CATEGORIES GRID ════════════════════════════════════════ --}}
@if($categories->isNotEmpty())
<section class="container-page py-16">
    <div class="mb-8">
        <p class="kicker">Browse by Domain</p>
        <h2 class="section-title mt-2">All Categories</h2>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($categories as $category)
        <a href="{{ $category->routeUrl() }}" class="knowledge-card group p-6 transition hover:-translate-y-1">
            <p class="text-xs font-black uppercase tracking-[.3em]" style="color:{{ $category->accent_color }}">{{ $category->name() }}</p>
            <p class="mt-3 text-sm leading-6 text-slate-500 group-hover:text-slate-400 transition">{{ $category->description() }}</p>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- ═══ QUOTE / MISSION STRIP ════════════════════════════════════ --}}
<section class="border-y border-white/6 bg-gradient-to-r from-amber-950/10 via-transparent to-amber-950/10 py-20">
    <div class="container-page text-center">
        <p class="mx-auto max-w-4xl text-2xl font-bold italic leading-relaxed text-slate-300 md:text-3xl">
            "The one who does not know history is destined to repeat it. The one who truly understands it — shapes the future."
        </p>
        <p class="mt-5 text-xs font-black uppercase tracking-[.4em] text-amber-400">— The Bitter Reality Archive</p>
    </div>
</section>

@endsection
