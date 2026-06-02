<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, string $category, string $slug): RedirectResponse
    {
        $topic = Topic::published()
            ->whereHas('category', fn($q) => $q->where('slug', $category))
            ->where('slug', $slug)
            ->firstOrFail();

        $validated = $request->validate([
            'author_name'  => ['required', 'string', 'max:100'],
            'author_email' => ['required', 'email', 'max:200'],
            'body'         => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        $topic->comments()->create([
            ...$validated,
            'is_approved' => false,
            'ip_address'  => $request->ip(),
        ]);

        return back()->with('comment_sent', true);
    }
}
