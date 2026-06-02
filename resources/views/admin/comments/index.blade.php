@extends('layouts.admin')
@section('title','Comments') @section('heading','Comment Moderation')
@section('content')
<div class="rounded-2xl border border-white/8 bg-white/[.02] overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-white/8 text-xs uppercase tracking-widest text-slate-600">
            <tr><th class="px-5 py-4 text-left">Author</th><th class="px-5 py-4 text-left">Topic</th><th class="px-5 py-4 text-left">Comment</th><th class="px-5 py-4 text-left">Status</th><th class="px-5 py-4 text-right">Actions</th></tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($comments as $comment)
            <tr class="hover:bg-white/[.02] {{ !$comment->is_approved ? 'bg-rose-950/5' : '' }}">
                <td class="px-5 py-4">
                    <p class="font-medium text-white">{{ $comment->author_name }}</p>
                    <p class="text-xs text-slate-600">{{ $comment->author_email }}</p>
                </td>
                <td class="px-5 py-4 text-xs text-slate-400">{{ $comment->topic?->trans('title', 'en') }}</td>
                <td class="px-5 py-4 max-w-xs">
                    <p class="text-sm text-slate-300 line-clamp-2">{{ $comment->body }}</p>
                    <p class="mt-1 text-xs text-slate-600">{{ $comment->created_at->diffForHumans() }}</p>
                </td>
                <td class="px-5 py-4">
                    <span class="rounded-full px-2.5 py-1 text-xs {{ $comment->is_approved ? 'bg-emerald-950/50 text-emerald-400' : 'bg-rose-950/50 text-rose-400' }}">
                        {{ $comment->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-3">
                        <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">@csrf @method('PATCH')
                            <button class="text-xs {{ $comment->is_approved ? 'text-slate-500' : 'text-emerald-400 hover:text-emerald-300' }}">{{ $comment->is_approved ? 'Unapprove' : 'Approve' }}</button>
                        </form>
                        <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" onsubmit="return confirm('Delete comment?')">@csrf @method('DELETE')
                            <button class="text-xs text-rose-500 hover:text-rose-400">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="py-12 text-center text-slate-600">No comments yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $comments->links() }}</div>
@endsection
