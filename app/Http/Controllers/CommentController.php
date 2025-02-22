<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $blogId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        Comment::create([
            'blog_id' => $blogId,
            'name' => Auth::check() ? Auth::user()->name : 'Anonymous', // Auto-fill or set "Anonymous"
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Your comment has been posted!');
    }
}
