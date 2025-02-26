<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create'); // Return the form view
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
        ]);

        // Create a new post
        Post::create([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function index()
    {
        // $posts = Post::all();
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
        ]);

        // Find and update the post
        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}
