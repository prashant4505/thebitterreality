@extends('layouts.public')

@section('content')
<section class="container-page py-14">
    <div class="mb-10">
        <p class="kicker">Search</p>
        <h1 class="section-title mt-2">{{ $q ? 'Results for "' . $q . '"' : 'Search the Knowledge Library' }}</h1>
    </div>

    <form action="{{ app()->getLocale() === 'hi' ? route('hi.search') : route('search') }}" class="mb-10 flex max-w-2xl flex-col gap-3 sm:flex-row">
        <input class="input flex-1" name="q" value="{{ $q }}" placeholder="Search topics, figures, events...">
        <button type="submit" class="btn-primary">Search</button>
    </form>

    @if($q)
        @if($topics->isNotEmpty())
        <div class="mb-10">
            <p class="kicker mb-5">Topics ({{ $topics->count() }})</p>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($topics as $topic)
                    @include('public.partials.topic-card', ['topic' => $topic])
                @endforeach
            </div>
        </div>
        @endif

        @if($figures->isNotEmpty())
        <div class="mb-10">
            <p class="kicker mb-5">Historical Figures ({{ $figures->count() }})</p>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($figures as $figure)
                <a href="{{ $figure->routeUrl() }}" class="knowledge-card flex gap-4 p-4 group">
                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-xl">
                        <img src="{{ $figure->imageUrl() }}" alt="{{ $figure->name() }}" class="h-full w-full object-cover">
                    </div>
                    <div>
                        @if($figure->era) <p class="text-xs text-amber-400">{{ $figure->era }}</p> @endif
                        <p class="font-bold text-white group-hover:text-amber-300 transition">{{ $figure->name() }}</p>
                        @if($figure->shortBio()) <p class="mt-1 text-xs text-slate-500 line-clamp-2">{{ $figure->shortBio() }}</p> @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($topics->isEmpty() && $figures->isEmpty())
        <div class="rounded-2xl border border-white/8 bg-white/[.025] py-16 text-center">
            <p class="text-lg text-slate-600">No results found for "{{ $q }}"</p>
            <p class="mt-2 text-sm text-slate-700">Try different keywords or browse categories</p>
        </div>
        @endif
    @else
        @if($trending->isNotEmpty())
        <div>
            <p class="kicker mb-5">Trending Searches</p>
            <div class="flex flex-wrap gap-3">
                @foreach($trending as $term)
                <a href="?q={{ urlencode($term) }}" class="rounded-full border border-white/10 bg-white/4 px-5 py-2.5 text-sm text-slate-400 transition hover:border-amber-400/40 hover:text-amber-300">{{ $term }}</a>
                @endforeach
            </div>
        </div>
        @endif
    @endif
</section>
@endsection
