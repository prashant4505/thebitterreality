@extends('layouts.admin')
@section('title', 'Topics')
@section('heading', 'Topics')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <p class="text-sm text-slate-500">{{ $topics->total() }} topics total</p>
    <a href="{{ route('admin.topics.create') }}" class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-bold text-black transition hover:bg-amber-300">+ New Topic</a>
</div>

<div class="rounded-2xl border border-white/8 bg-white/[.02] overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-white/8 text-xs uppercase tracking-widest text-slate-600">
            <tr>
                <th class="px-5 py-4 text-left">Title</th>
                <th class="px-5 py-4 text-left">Category</th>
                <th class="px-5 py-4 text-left">Status</th>
                <th class="px-5 py-4 text-left">Views</th>
                <th class="px-5 py-4 text-left">Updated</th>
                <th class="px-5 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($topics as $topic)
            <tr class="hover:bg-white/[.025] transition">
                <td class="px-5 py-4">
                    <p class="font-medium text-white">{{ $topic->trans('title', 'en') ?? $topic->slug }}</p>
                    @if($topic->trans('title', 'hi')) <p class="text-xs text-slate-600">HI: {{ Str::limit($topic->trans('title', 'hi'), 50) }}</p> @endif
                </td>
                <td class="px-5 py-4 text-slate-400">{{ $topic->category?->trans('name', 'en') }}</td>
                <td class="px-5 py-4">
                    <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $topic->is_published ? 'bg-emerald-950/50 text-emerald-400' : 'bg-slate-800 text-slate-500' }}">
                        {{ $topic->is_published ? 'Published' : 'Draft' }}
                    </span>
                    @if($topic->is_featured) <span class="ml-1 rounded-full bg-amber-950/50 px-2.5 py-1 text-xs font-bold text-amber-400">Featured</span> @endif
                </td>
                <td class="px-5 py-4 text-slate-500">{{ number_format($topic->view_count) }}</td>
                <td class="px-5 py-4 text-slate-600 text-xs">{{ $topic->updated_at->diffForHumans() }}</td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.topics.chapters.index', $topic) }}" class="text-xs text-cyan-400 hover:text-cyan-300">Chapters</a>
                        <a href="{{ route('admin.topics.edit', $topic) }}" class="text-xs text-amber-400 hover:text-amber-300">Edit</a>
                        <form method="POST" action="{{ route('admin.topics.destroy', $topic) }}" onsubmit="return confirm('Delete this topic?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-rose-500 hover:text-rose-400">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-slate-600">No topics yet. <a href="{{ route('admin.topics.create') }}" class="text-amber-400">Create one</a>.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $topics->links() }}</div>
@endsection
