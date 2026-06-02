@extends('layouts.admin')
@section('title','Categories') @section('heading','Categories')
@section('content')
<div class="mb-5 flex justify-between">
    <p class="text-sm text-slate-500">{{ $categories->total() }} categories</p>
    <a href="{{ route('admin.categories.create') }}" class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-bold text-black">+ New</a>
</div>
<div class="rounded-2xl border border-white/8 bg-white/[.02] overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-white/8 text-xs uppercase tracking-widest text-slate-600">
            <tr><th class="px-5 py-4 text-left">Name</th><th class="px-5 py-4 text-left">Slug</th><th class="px-5 py-4 text-left">Color</th><th class="px-5 py-4 text-left">Status</th><th class="px-5 py-4 text-right">Actions</th></tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($categories as $cat)
            <tr class="hover:bg-white/[.02]">
                <td class="px-5 py-4 font-medium text-white">{{ $cat->trans('name', 'en') ?? $cat->slug }}</td>
                <td class="px-5 py-4 font-mono text-xs text-slate-500">{{ $cat->slug }}</td>
                <td class="px-5 py-4"><span class="inline-block h-4 w-4 rounded-full" style="background:{{ $cat->accent_color }}"></span></td>
                <td class="px-5 py-4"><span class="rounded-full px-2.5 py-1 text-xs {{ $cat->is_active ? 'bg-emerald-950/50 text-emerald-400' : 'bg-slate-800 text-slate-500' }}">{{ $cat->is_active ? 'Active' : 'Hidden' }}</span></td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="text-xs text-amber-400 hover:text-amber-300">Edit</a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Delete category?')">@csrf @method('DELETE')<button class="text-xs text-rose-500">Delete</button></form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="py-12 text-center text-slate-600">No categories yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $categories->links() }}</div>
@endsection
