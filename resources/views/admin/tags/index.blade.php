@extends('layouts.admin')
@section('title','Tags') @section('heading','Tags')
@section('content')
<div class="mb-5 flex justify-between">
    <p class="text-sm text-slate-500">{{ $tags->total() }} tags</p>
    <a href="{{ route('admin.tags.create') }}" class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-bold text-black">+ New Tag</a>
</div>
<div class="flex flex-wrap gap-3">
    @forelse($tags as $tag)
    <div class="flex items-center gap-2 rounded-full border border-white/10 bg-white/[.03] px-4 py-2">
        <span class="text-sm text-white">{{ $tag->trans('name', 'en') ?? $tag->slug }}</span>
        <a href="{{ route('admin.tags.edit', $tag) }}" class="text-xs text-amber-400 hover:text-amber-300">edit</a>
        <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" onsubmit="return confirm('Delete tag?')">@csrf @method('DELETE')<button class="text-xs text-rose-500">×</button></form>
    </div>
    @empty
    <p class="text-slate-600">No tags yet.</p>
    @endforelse
</div>
<div class="mt-5">{{ $tags->links() }}</div>
@endsection
