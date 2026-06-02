@extends('layouts.admin')
@section('title', 'Figures')
@section('heading', 'Historical Figures')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <p class="text-sm text-slate-500">{{ $figures->total() }} figures total</p>
    <a href="{{ route('admin.figures.create') }}" class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-bold text-black">+ New Figure</a>
</div>

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @forelse($figures as $figure)
    <div class="rounded-2xl border border-white/8 bg-white/[.02] p-5 flex gap-4">
        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-xl bg-white/5">
            <img src="{{ $figure->imageUrl() }}" alt="{{ $figure->trans('name', 'en') }}" class="h-full w-full object-cover">
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-bold text-white truncate">{{ $figure->trans('name', 'en') ?? $figure->slug }}</p>
            @if($figure->era) <p class="text-xs text-amber-400">{{ $figure->era }}</p> @endif
            @if($figure->born || $figure->died) <p class="text-xs text-slate-600">{{ $figure->born }}{{ $figure->died ? ' – ' . $figure->died : '' }}</p> @endif
            <div class="mt-3 flex gap-3">
                <a href="{{ route('admin.figures.edit', $figure) }}" class="text-xs text-amber-400 hover:text-amber-300">Edit</a>
                <form method="POST" action="{{ route('admin.figures.destroy', $figure) }}" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-rose-500 hover:text-rose-400">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-16 text-center text-slate-600">No figures yet. <a href="{{ route('admin.figures.create') }}" class="text-amber-400">Create one</a>.</div>
    @endforelse
</div>
<div class="mt-6">{{ $figures->links() }}</div>
@endsection
