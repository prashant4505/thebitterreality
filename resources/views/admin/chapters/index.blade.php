@extends('layouts.admin')
@section('title', 'Chapters')
@section('heading', 'Chapters — ' . ($topic->trans('title', 'en') ?? $topic->slug))

@section('content')
<div class="mb-5 flex items-center justify-between">
    <a href="{{ route('admin.topics.index') }}" class="text-sm text-slate-500 hover:text-amber-400">← Back to Topics</a>
    <a href="{{ route('admin.topics.chapters.create', $topic) }}" class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-bold text-black">+ Add Chapter</a>
</div>

<div class="rounded-2xl border border-white/8 bg-white/[.02] overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-white/8 text-xs uppercase tracking-widest text-slate-600">
            <tr>
                <th class="px-5 py-4 text-left">#</th>
                <th class="px-5 py-4 text-left">Title</th>
                <th class="px-5 py-4 text-left">Status</th>
                <th class="px-5 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($topic->chapters as $chapter)
            <tr class="hover:bg-white/[.02]">
                <td class="px-5 py-4 text-slate-600 font-mono">{{ str_pad($chapter->sort_order, 2, '0', STR_PAD_LEFT) }}</td>
                <td class="px-5 py-4">
                    <p class="font-medium text-white">{{ $chapter->trans('title', 'en') ?? $chapter->slug }}</p>
                    @if($chapter->trans('title', 'hi')) <p class="text-xs text-slate-600">HI: {{ $chapter->trans('title', 'hi') }}</p> @endif
                </td>
                <td class="px-5 py-4">
                    <span class="rounded-full px-2.5 py-1 text-xs {{ $chapter->is_published ? 'bg-emerald-950/50 text-emerald-400' : 'bg-slate-800 text-slate-500' }}">
                        {{ $chapter->is_published ? 'Live' : 'Draft' }}
                    </span>
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.chapters.edit', $chapter) }}" class="text-xs text-amber-400 hover:text-amber-300">Edit</a>
                        <form method="POST" action="{{ route('admin.chapters.destroy', $chapter) }}" onsubmit="return confirm('Delete chapter?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-rose-500 hover:text-rose-400">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-5 py-12 text-center text-slate-600">No chapters yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
