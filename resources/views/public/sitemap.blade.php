@extends('layouts.public')

@section('content')
<section class="container-page py-14">
    <p class="kicker">Navigation</p>
    <h1 class="section-title mt-3">Sitemap</h1>

    <div class="mt-10 grid gap-6 sm:grid-cols-2">
        <div class="rounded-2xl border border-white/8 bg-white/[.025] p-6">
            <p class="mb-4 text-xs font-black uppercase tracking-widest text-amber-400" style="font-family:Inter,sans-serif">Topics</p>
            <div class="space-y-2">
                @foreach($topics as $topic)
                <a href="{{ $topic->routeUrl() }}" class="block text-sm text-slate-400 transition hover:text-amber-300">{{ $topic->title() }}</a>
                @endforeach
            </div>
        </div>
        <div class="rounded-2xl border border-white/8 bg-white/[.025] p-6">
            <p class="mb-4 text-xs font-black uppercase tracking-widest text-amber-400" style="font-family:Inter,sans-serif">Pages</p>
            <div class="space-y-2">
                <a href="{{ route('home') }}" class="block text-sm text-slate-400 transition hover:text-amber-300">Home</a>
                <a href="{{ route('topics.index') }}" class="block text-sm text-slate-400 transition hover:text-amber-300">All Topics</a>
                <a href="{{ route('figures.index') }}" class="block text-sm text-slate-400 transition hover:text-amber-300">Historical Figures</a>
                <a href="{{ route('search') }}" class="block text-sm text-slate-400 transition hover:text-amber-300">Search</a>
            </div>
        </div>
    </div>
</section>
@endsection
