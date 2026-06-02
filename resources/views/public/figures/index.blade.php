@extends('layouts.public')

@section('content')
<section class="container-page py-16">
    <div class="mb-10">
        <p class="kicker">Profiles</p>
        <h1 class="section-title mt-2">Historical Figures</h1>
        <p class="mt-4 max-w-2xl text-lg text-slate-500">Complete biographies of the greatest minds, leaders, scientists, philosophers, and rulers who shaped our world.</p>
    </div>

    @if($eras->isNotEmpty())
    <div class="mb-8 flex flex-wrap gap-2" style="font-family:Inter,sans-serif">
        <a href="?" class="rounded-full border border-amber-400/40 bg-amber-950/30 px-4 py-2 text-xs font-bold text-amber-400">All Eras</a>
        @foreach($eras as $era)
        <a href="?era={{ urlencode($era) }}" class="rounded-full border border-white/10 bg-white/4 px-4 py-2 text-xs font-bold text-slate-400 transition hover:border-amber-400/40 hover:text-amber-300 {{ request('era') === $era ? 'border-amber-400/40 text-amber-300' : '' }}">{{ $era }}</a>
        @endforeach
    </div>
    @endif

    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($figures as $figure)
        <a href="{{ $figure->routeUrl() }}" class="knowledge-card group overflow-hidden flex flex-col sm:flex-row">
            <div class="h-44 w-full flex-shrink-0 overflow-hidden sm:h-auto sm:w-28">
                <img src="{{ $figure->imageUrl() }}" alt="{{ $figure->name() }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
            </div>
            <div class="flex min-w-0 flex-col p-4">
                @if($figure->era) <p class="text-xs font-bold uppercase tracking-widest text-amber-400">{{ $figure->era }}</p> @endif
                <h3 class="mt-1 truncate font-bold text-white transition group-hover:text-amber-300">{{ $figure->name() }}</h3>
                @if($figure->title()) <p class="truncate text-xs text-slate-500">{{ $figure->title() }}</p> @endif
                @if($figure->born || $figure->died)
                <p class="mt-1 text-xs text-slate-600">{{ $figure->born }}{{ $figure->died ? ' – ' . $figure->died : '' }}</p>
                @endif
                @if($figure->shortBio())
                <p class="mt-2 flex-1 text-xs leading-5 text-slate-500 line-clamp-3">{{ $figure->shortBio() }}</p>
                @endif
            </div>
        </a>
        @empty
        <div class="col-span-full py-20 text-center text-slate-600">No historical figures found.</div>
        @endforelse
    </div>

    <div class="mt-10">{{ $figures->links() }}</div>
</section>
@endsection
