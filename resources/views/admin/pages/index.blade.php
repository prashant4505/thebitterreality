@extends('layouts.admin')
@section('title','Pages') @section('heading','Static Pages')
@section('content')
<div class="mb-5 flex justify-between">
    <p class="text-sm text-slate-500">{{ $pages->total() }} pages</p>
    <a href="{{ route('admin.pages.create') }}" class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-bold text-black">+ New Page</a>
</div>
<div class="rounded-2xl border border-white/8 bg-white/[.02] overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-white/8 text-xs uppercase tracking-widest text-slate-600">
            <tr><th class="px-5 py-4 text-left">Title</th><th class="px-5 py-4 text-left">Slug</th><th class="px-5 py-4 text-left">Status</th><th class="px-5 py-4 text-right">Actions</th></tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($pages as $page)
            <tr class="hover:bg-white/[.02]">
                <td class="px-5 py-4 font-medium text-white">{{ $page->trans('title', 'en') ?? $page->slug }}</td>
                <td class="px-5 py-4 font-mono text-xs text-slate-500">{{ $page->slug }}</td>
                <td class="px-5 py-4"><span class="rounded-full px-2.5 py-1 text-xs {{ $page->is_published ? 'bg-emerald-950/50 text-emerald-400' : 'bg-slate-800 text-slate-500' }}">{{ $page->is_published ? 'Live' : 'Draft' }}</span></td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="text-xs text-amber-400 hover:text-amber-300">Edit</a>
                        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-xs text-rose-500">Delete</button></form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="py-12 text-center text-slate-600">No pages yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $pages->links() }}</div>
@endsection
