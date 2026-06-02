@extends('layouts.admin')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
{{-- Stats --}}
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @foreach([
        ['Topics', $totalTopics, $publishedTopics . ' published', 'amber'],
        ['Figures', $totalFigures, 'Historical profiles', 'cyan'],
        ['Comments', $totalComments, $pendingComments . ' pending', 'rose'],
        ['Categories', $totalCategories, $totalTags . ' tags', 'emerald'],
    ] as [$label, $count, $sub, $color])
    <div class="rounded-2xl border border-white/8 bg-white/[.03] p-6">
        <p class="text-xs font-black uppercase tracking-[.3em] text-{{ $color }}-400">{{ $label }}</p>
        <p class="mt-2 text-4xl font-black text-white">{{ number_format($count) }}</p>
        <p class="mt-1 text-xs text-slate-600">{{ $sub }}</p>
    </div>
    @endforeach
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="rounded-2xl border border-white/8 bg-white/[.025] p-6">
        <div class="mb-5 flex items-center justify-between">
            <p class="text-sm font-bold text-white">Recent Topics</p>
            <a href="{{ route('admin.topics.create') }}" class="rounded-xl bg-amber-400 px-3 py-1.5 text-xs font-bold text-black transition hover:bg-amber-300">+ New</a>
        </div>
        <div class="space-y-3">
            @foreach($recentTopics as $topic)
            <div class="flex items-center gap-3">
                <div class="flex-1 min-w-0">
                    <p class="truncate text-sm font-medium text-white">{{ $topic->trans('title', 'en') ?? $topic->slug }}</p>
                    <p class="text-xs text-slate-600">{{ $topic->created_at->diffForHumans() }}</p>
                </div>
                <span class="flex-shrink-0 rounded-full px-2 py-0.5 text-xs {{ $topic->is_published ? 'bg-emerald-950/50 text-emerald-400' : 'bg-slate-800 text-slate-500' }}">
                    {{ $topic->is_published ? 'Live' : 'Draft' }}
                </span>
                <a href="{{ route('admin.topics.edit', $topic) }}" class="text-xs text-amber-400 hover:text-amber-300">Edit</a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="rounded-2xl border border-white/8 bg-white/[.025] p-6">
        <p class="mb-5 text-sm font-bold text-white">Top Viewed Topics</p>
        <div class="space-y-3">
            @foreach($topViewed as $i => $topic)
            <div class="flex items-center gap-3">
                <span class="flex-shrink-0 text-xs font-black text-amber-700">#{{ $i + 1 }}</span>
                <p class="flex-1 truncate text-sm text-slate-300">{{ $topic->trans('title', 'en') ?? $topic->slug }}</p>
                <span class="text-xs text-slate-600">{{ number_format($topic->view_count) }} views</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="mt-6 flex flex-wrap gap-3">
    <a href="{{ route('admin.topics.create') }}" class="rounded-full bg-amber-400 px-5 py-2.5 text-sm font-bold text-black">+ New Topic</a>
    <a href="{{ route('admin.figures.create') }}" class="rounded-full border border-white/10 bg-white/4 px-5 py-2.5 text-sm font-bold text-white">+ New Figure</a>
    <a href="{{ route('admin.categories.create') }}" class="rounded-full border border-white/10 bg-white/4 px-5 py-2.5 text-sm font-bold text-white">+ Category</a>
    <a href="{{ route('admin.comments.index') }}" class="rounded-full border border-rose-400/30 bg-rose-950/20 px-5 py-2.5 text-sm font-bold text-rose-300">Moderate ({{ $pendingComments }} pending)</a>
</div>
@endsection
