<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Retrieve all comments for a specific blog post.
     */
    public function index($blogId)
    {
        $comments = Comment::where('blog_id', $blogId)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'comments' => $comments->map(function ($comment) {
                return [
                    'comment' => $comment->comment,
                    'name' => $comment->name,
                    'date' => $comment->created_at->format('F j, Y'),
                ];
            }),
        ]);
    }

    /**
     * Store a new comment.
     */
    public function store(Request $request, $blogId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = Comment::create([
            'blog_id' => $blogId,
            'name' => Auth::check() ? Auth::user()->name : 'Anonymous', // Auto-fill or set "Anonymous"
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully!',
            'comment' => [
                'comment' => $comment->comment,
                'name' => $comment->name,
                'date' => $comment->created_at->format('F j, Y'),
            ],
        ]);
    }
}
