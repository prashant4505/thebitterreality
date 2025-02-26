<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Post::latest(); // Fetch latest posts first

        // Apply category filter if provided
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        $posts = $query->paginate(10); // Paginate results

        return response()->json([
            'success' => true,
            'message' => 'Posts retrieved successfully',
            'data' => $posts
        ], 200);
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
        ]);

        $post = Post::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully',
            'data' => $post
        ], 201);
    }

    /**
     * Display the specified post.
     */
    public function show(int $id): JsonResponse
    {
        $post = Post::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Post retrieved successfully',
            'data' => $post
        ], 200);
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'category' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]);

        $post->update(array_filter($validated)); // Prevent empty values from being updated

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => $post
        ], 200);
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
