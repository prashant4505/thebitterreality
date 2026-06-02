@extends('layouts.public')

@section('content')
@php
    $locale = app()->getLocale();
    $chapters = $topic->chapters;
    $timeline = $topic->timelines->first();
    $figures = $topic->figures;
    $relatedTopics = $topic->relatedTopics;
@endphp

{{-- Reading Progress Bar --}}
<div class="reading-progress" id="readingProgress" style="width:0%"></div>

{{-- ═══ TOPIC HERO ═══════════════════════════════════════════════ --}}
<section class="relative overflow-hidden">
    @if($topic->featured_image)
    <img src="{{ $topic->imageUrl() }}" alt="{{ $topic->title() }}" class="absolute inset-0 h-full w-full object-cover opacity-20">
    @endif
    <div class="absolute inset-0 bg-gradient-to-b from-[#02030a]/60 via-[#02030a]/80 to-[#02030a]"></div>

    <div class="container-page relative z-10 py-20 lg:py-28">
        {{-- Breadcrumb --}}
        <nav class="mb-6 flex items-center gap-2 text-xs text-slate-600" style="font-family:Inter,sans-serif">
            <a href="{{ $locale === 'hi' ? route('hi.home') : route('home') }}" class="hover:text-amber-400 transition">Home</a>
            <span>/</span>
            @if($topic->category)
            <a href="{{ $topic->category->routeUrl() }}" class="hover:text-amber-400 transition">{{ $topic->category->name() }}</a>
            <span>/</span>
            @endif
            <span class="text-slate-400">{{ $topic->title() }}</span>
        </nav>

        <div class="max-w-4xl">
            <div class="flex flex-wrap items-center gap-2">
                @if($topic->category)
                <span class="badge-category" style="border-color:{{ $topic->category->accent_color }}50; color:{{ $topic->category->accent_color }}">{{ $topic->category->name() }}</span>
                @endif
                @if($topic->era) <span class="badge-era">{{ $topic->era }}</span> @endif
                @if($topic->region) <span class="badge-difficulty">{{ $topic->region }}</span> @endif
                <span class="badge-difficulty">{{ ucfirst($topic->difficulty) }}</span>
            </div>

            <h1 class="page-title mt-5">{{ $topic->title() }}</h1>

            @if($topic->subtitle())
            <p class="mt-4 text-lg sm:text-2xl font-medium leading-8 text-slate-400">{{ $topic->subtitle() }}</p>
            @endif

            @if($topic->excerpt())
            <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-400">{{ $topic->excerpt() }}</p>
            @endif

            <div class="mt-8 flex flex-wrap items-center gap-6 text-sm text-slate-600" style="font-family:Inter,sans-serif">
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $topic->reading_time }} min read
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    {{ number_format($topic->view_count) }} views
                </span>
                @if($chapters->count())
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    {{ $chapters->count() }} chapters
                </span>
                @endif

                {{-- Bookmark button --}}
                <button id="bookmarkBtn" onclick="toggleBookmark()"
                        class="flex items-center gap-1.5 rounded-full border border-white/10 bg-white/4 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-slate-400 transition hover:border-amber-400/40 hover:text-amber-300">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    <span>Bookmark</span>
                </button>
            </div>

            {{-- Tags --}}
            @if($topic->tags->isNotEmpty())
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach($topic->tags as $tag)
                <span class="rounded-full border border-white/10 bg-white/4 px-3 py-1 text-xs text-slate-500">{{ $tag->name() }}</span>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ═══ TIMELINE STRIP ══════════════════════════════════════════ --}}
@if($timeline && $timeline->entries->isNotEmpty())
<section class="border-y border-white/6 bg-amber-950/5 py-12">
    <div class="container-page">
        <p class="kicker mb-6">Historical Timeline</p>
        <div class="relative overflow-x-auto pb-4">
            <div class="flex gap-0 min-w-max">
                @foreach($timeline->entries as $i => $entry)
                <div class="relative flex flex-col items-center" style="width:180px">
                    {{-- Line --}}
                    @if(!$loop->last)
                    <div class="absolute top-3 left-1/2 w-full h-px bg-gradient-to-r from-amber-400/60 to-amber-400/20"></div>
                    @endif
                    {{-- Dot --}}
                    <div class="relative z-10 h-6 w-6 rounded-full border-2 border-amber-400 bg-[#02030a] shadow-[0_0_12px_rgba(251,191,36,.5)]
                                {{ $entry->type === 'turning_point' ? 'border-rose-400 shadow-[0_0_12px_rgba(251,113,133,.5)]' : '' }}
                                {{ $entry->type === 'milestone' ? 'border-emerald-400 shadow-[0_0_12px_rgba(52,211,153,.5)]' : '' }}">
                    </div>
                    {{-- Date --}}
                    <p class="mt-3 text-xs font-black text-amber-400">{{ $entry->date_label }}</p>
                    <p class="mt-1 px-2 text-center text-xs leading-4 text-slate-400">{{ $entry->title() }}</p>
                </div>
                @endforeach
            </div>
        </div>
        <div class="mt-4 flex gap-4 text-xs text-slate-600" style="font-family:Inter,sans-serif">
            <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full border border-amber-400"></span> Event</span>
            <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full border border-rose-400"></span> Turning Point</span>
            <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full border border-emerald-400"></span> Milestone</span>
        </div>
    </div>
</section>
@endif

{{-- ═══ MAIN CONTENT + SIDEBAR ═══════════════════════════════════ --}}
<div class="container-page py-12 lg:py-16">
    <div class="grid gap-10 lg:grid-cols-[1fr_300px]" x-data="{ activeChapter: 0 }">

        {{-- ─── Content Area ──────────────────────────────────── --}}
        <div>
            {{-- Mobile Table of Contents --}}
            @if($chapters->count() > 1)
            <div class="mb-8 rounded-2xl border border-white/8 bg-white/[.03] p-5 lg:hidden" x-data="{ tocOpen: false }" style="font-family:Inter,sans-serif">
                <button @click="tocOpen = !tocOpen" class="flex w-full items-center justify-between text-xs font-black uppercase tracking-widest text-amber-400">
                    <span>Table of Contents</span>
                    <svg class="h-4 w-4 transition-transform duration-200" :class="tocOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <nav x-show="tocOpen" x-transition class="mt-4 space-y-1">
                    @foreach($chapters as $i => $chapter)
                    <a href="#chapter-{{ $chapter->id }}" @click="tocOpen = false" class="toc-link flex items-start gap-2">
                        <span class="mt-0.5 flex-shrink-0 text-xs font-black text-amber-700">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span>{{ $chapter->title() }}</span>
                    </a>
                    @endforeach
                </nav>
            </div>
            @endif

            {{-- Overview --}}
            @if($topic->overview())
            <div class="prose-doc mb-12">
                {!! $topic->overview() !!}
            </div>
            @endif

            {{-- Chapters --}}
            @foreach($chapters as $chapterIdx => $chapter)
            <article class="mb-16" id="chapter-{{ $chapter->id }}" data-chapter="{{ $chapterIdx }}">
                {{-- Chapter header --}}
                <div class="mb-8 border-l-4 border-amber-400 pl-6">
                    <p class="kicker">Chapter {{ $chapterIdx + 1 }}</p>
                    <h2 class="mt-2 text-3xl font-bold text-white leading-tight" style="font-family:Inter,sans-serif">{{ $chapter->title() }}</h2>
                    @if($chapter->summary())
                    <p class="mt-3 text-lg text-slate-400 leading-7">{{ $chapter->summary() }}</p>
                    @endif
                </div>

                @if($chapter->featured_image)
                <img src="{{ asset('storage/' . $chapter->featured_image) }}" alt="{{ $chapter->title() }}" class="mb-8 w-full rounded-2xl object-cover shadow-2xl" style="max-height:400px">
                @endif

                {{-- Chapter content --}}
                <div class="prose-doc">
                    {!! $chapter->content() !!}
                </div>

                {{-- Pull Quotes --}}
                @foreach($chapter->pullQuotes() as $pq)
                <div class="pull-quote my-10">
                    <p class="text-xl font-bold italic text-amber-100 leading-8">"{{ $pq['quote'] }}"</p>
                    @if(!empty($pq['source']))
                    <p class="mt-3 text-sm font-bold uppercase tracking-widest text-amber-500">— {{ $pq['source'] }}</p>
                    @endif
                </div>
                @endforeach

                {{-- Fact Boxes --}}
                @foreach($chapter->factBoxes() as $fb)
                <div class="fact-box">
                    @if(!empty($fb['title']))
                    <p class="mb-3 text-sm font-black uppercase tracking-widest text-emerald-400" style="font-family:Inter,sans-serif">{{ $fb['title'] }}</p>
                    @endif
                    <ul class="space-y-2">
                        @foreach($fb['facts'] ?? [] as $fact)
                        <li class="flex items-start gap-2 text-sm text-slate-300">
                            <span class="mt-1 h-1.5 w-1.5 flex-shrink-0 rounded-full bg-emerald-400"></span>
                            {{ $fact }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach

                {{-- Key Lessons --}}
                @if($chapter->keyLessons())
                <div class="my-8 rounded-2xl border border-amber-400/20 bg-amber-950/10 p-6">
                    <p class="mb-4 text-xs font-black uppercase tracking-widest text-amber-400" style="font-family:Inter,sans-serif">Key Lessons</p>
                    <ul class="space-y-3">
                        @foreach($chapter->keyLessons() as $lesson)
                        <li class="flex items-start gap-3 text-sm text-slate-300">
                            <span class="mt-0.5 flex-shrink-0 text-amber-400">→</span>
                            {{ $lesson }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Myths vs Facts --}}
                @if($chapter->mythsVsFacts())
                <div class="my-8">
                    <p class="mb-5 text-xs font-black uppercase tracking-widest text-rose-400" style="font-family:Inter,sans-serif">Myths vs Facts</p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach($chapter->mythsVsFacts() as $mvf)
                        <div class="myth-box">
                            <p class="mb-2 text-xs font-black uppercase tracking-widest text-rose-400">Myth</p>
                            <p class="text-sm text-slate-300">{{ $mvf['myth'] }}</p>
                        </div>
                        <div class="fact-truth-box">
                            <p class="mb-2 text-xs font-black uppercase tracking-widest text-emerald-400">Fact</p>
                            <p class="text-sm text-slate-300">{{ $mvf['fact'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Chapter divider --}}
                @if(!$loop->last)
                <div class="my-16 flex items-center gap-4">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
                    <span class="text-xs font-black uppercase tracking-widest text-slate-700">Next Chapter</span>
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
                </div>
                @endif
            </article>
            @endforeach

            {{-- ─── Historical Figures mentioned ─────────────── --}}
            @if($figures->isNotEmpty())
            <section class="mt-12 border-t border-white/8 pt-12">
                <p class="kicker mb-6">Key Personalities</p>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($figures as $figure)
                    <a href="{{ $figure->routeUrl() }}" class="knowledge-card flex gap-4 p-4 group">
                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-xl">
                            <img src="{{ $figure->imageUrl() }}" alt="{{ $figure->name() }}" class="h-full w-full object-cover">
                        </div>
                        <div>
                            @if($figure->pivot->role) <p class="text-xs font-bold uppercase tracking-widest text-amber-400">{{ $figure->pivot->role }}</p> @endif
                            <p class="font-bold text-white transition group-hover:text-amber-300">{{ $figure->name() }}</p>
                            @if($figure->title()) <p class="text-xs text-slate-500">{{ $figure->title() }}</p> @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- ─── Comments ──────────────────────────────────── --}}
            <section class="mt-14 border-t border-white/8 pt-12">
                <p class="kicker mb-6">Discussion</p>

                @if(session('comment_sent'))
                <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-950/20 p-5 text-sm text-emerald-300">Your comment is pending approval. Thank you!</div>
                @endif

                {{-- Approved comments --}}
                @php $approvedComments = $topic->comments->where('is_approved', true)->whereNull('parent_id'); @endphp
                @if($approvedComments->isNotEmpty())
                <div class="mb-10 space-y-5">
                    @foreach($approvedComments as $comment)
                    <div class="rounded-2xl border border-white/8 bg-white/[.03] p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-xs font-black text-black">{{ strtoupper(substr($comment->author_name, 0, 1)) }}</div>
                            <div>
                                <p class="text-sm font-bold text-white">{{ $comment->author_name }}</p>
                                <p class="text-xs text-slate-600">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-sm leading-7 text-slate-400">{{ $comment->body }}</p>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Comment form --}}
                <form action="{{ $locale === 'hi' ? route('hi.comments.store', [$topic->category->slug, $topic->slug]) : route('comments.store', [$topic->category->slug, $topic->slug]) }}"
                      method="POST" class="rounded-2xl border border-white/8 bg-white/[.025] p-6">
                    @csrf
                    <p class="mb-6 font-bold text-white" style="font-family:Inter,sans-serif">Leave a Comment</p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-bold uppercase tracking-widest text-slate-500">Name</label>
                            <input class="input" name="author_name" required placeholder="Your name" value="{{ old('author_name') }}">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-bold uppercase tracking-widest text-slate-500">Email</label>
                            <input class="input" name="author_email" type="email" required placeholder="your@email.com" value="{{ old('author_email') }}">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-widest text-slate-500">Comment</label>
                        <textarea class="input h-32 resize-none" name="body" required placeholder="Share your thoughts...">{{ old('body') }}</textarea>
                    </div>
                    @if($errors->any())
                    <p class="mt-3 text-sm text-rose-400">{{ $errors->first() }}</p>
                    @endif
                    <button type="submit" class="btn-primary mt-5">Submit Comment</button>
                </form>
            </section>
        </div>

        {{-- ─── Sidebar ──────────────────────────────────────── --}}
        <aside class="hidden lg:block">
            <div class="sticky top-24 space-y-6">

                {{-- Table of Contents --}}
                @if($chapters->count() > 1)
                <div class="rounded-2xl border border-white/8 bg-white/[.03] p-5" style="font-family:Inter,sans-serif">
                    <p class="mb-4 text-xs font-black uppercase tracking-widest text-amber-400">Table of Contents</p>
                    <nav id="tocNav" class="space-y-1">
                        @foreach($chapters as $i => $chapter)
                        <a href="#chapter-{{ $chapter->id }}"
                           class="toc-link flex items-start gap-2"
                           data-chapter="{{ $i }}">
                            <span class="mt-0.5 flex-shrink-0 text-xs font-black text-amber-700">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span>{{ $chapter->title() }}</span>
                        </a>
                        @endforeach
                    </nav>
                </div>
                @endif

                {{-- Topic stats --}}
                <div class="rounded-2xl border border-white/8 bg-white/[.03] p-5" style="font-family:Inter,sans-serif">
                    <p class="mb-4 text-xs font-black uppercase tracking-widest text-amber-400">Topic Details</p>
                    <div class="space-y-3 text-sm">
                        @if($topic->era) <div class="flex justify-between"><span class="text-slate-600">Era</span><span class="text-slate-300">{{ $topic->era }}</span></div> @endif
                        @if($topic->region) <div class="flex justify-between"><span class="text-slate-600">Region</span><span class="text-slate-300">{{ $topic->region }}</span></div> @endif
                        <div class="flex justify-between"><span class="text-slate-600">Level</span><span class="text-slate-300">{{ ucfirst($topic->difficulty) }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-600">Reading Time</span><span class="text-slate-300">{{ $topic->reading_time }} min</span></div>
                        <div class="flex justify-between"><span class="text-slate-600">Views</span><span class="text-slate-300">{{ number_format($topic->view_count) }}</span></div>
                    </div>
                </div>

                {{-- Related Topics --}}
                @if($relatedTopics->isNotEmpty())
                <div class="rounded-2xl border border-white/8 bg-white/[.03] p-5" style="font-family:Inter,sans-serif">
                    <p class="mb-4 text-xs font-black uppercase tracking-widest text-amber-400">Related Topics</p>
                    <div class="space-y-3">
                        @foreach($relatedTopics as $related)
                        <a href="{{ $related->routeUrl() }}" class="flex gap-3 group">
                            @if($related->featured_image)
                            <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg">
                                <img src="{{ $related->imageUrl() }}" alt="{{ $related->title() }}" class="h-full w-full object-cover">
                            </div>
                            @endif
                            <p class="text-sm text-slate-400 leading-5 group-hover:text-amber-300 transition">{{ $related->title() }}</p>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </aside>
    </div>
</div>

{{-- ═══ BACK TO CATEGORY ══════════════════════════════════════════ --}}
@if($topic->category)
<section class="border-t border-white/8 py-10">
    <div class="container-page flex flex-col items-center gap-4 text-center sm:flex-row sm:text-left">
        <div class="flex-1">
            <p class="text-xs font-black uppercase tracking-widest text-slate-600" style="font-family:Inter,sans-serif">More in {{ $topic->category->name() }}</p>
            <p class="mt-1 text-sm text-slate-500">Continue exploring this category</p>
        </div>
        <a href="{{ $topic->category->routeUrl() }}" class="btn-primary">Explore {{ $topic->category->name() }} →</a>
    </div>
</section>
@endif

<script>
    // Reading progress
    window.addEventListener('scroll', () => {
        const el = document.getElementById('readingProgress');
        if (!el) return;
        const pct = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight) * 100;
        el.style.width = Math.min(pct, 100) + '%';
    });

    // Active TOC chapter highlight
    const chapters = document.querySelectorAll('[data-chapter]');
    const tocLinks = document.querySelectorAll('#tocNav a');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const idx = entry.target.dataset.chapter;
                tocLinks.forEach(l => l.classList.remove('active'));
                const active = document.querySelector(`#tocNav a[data-chapter="${idx}"]`);
                if (active) active.classList.add('active');
            }
        });
    }, { rootMargin: '-20% 0px -60% 0px' });
    chapters.forEach(c => observer.observe(c));

    // Bookmark toggle
    function toggleBookmark() {
        fetch('{{ $locale === "hi" ? route("hi.bookmark.toggle", [$topic->category->slug ?? "general", $topic->slug]) : route("bookmark.toggle", [$topic->category->slug ?? "general", $topic->slug]) }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        }).then(r => r.json()).then(d => {
            const btn = document.getElementById('bookmarkBtn');
            btn.classList.toggle('text-amber-400', d.bookmarked);
            btn.querySelector('span').textContent = d.bookmarked ? 'Bookmarked' : 'Bookmark';
        });
    }
</script>
@endsection
