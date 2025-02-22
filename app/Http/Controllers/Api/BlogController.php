<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // Store a new blog post
    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Return validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create blog post
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->user_id = Auth::id();

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $blog->image = $imagePath;
        }

        $blog->save();

        return response()->json([
            'message' => 'Blog created successfully!',
            'blog' => $blog
        ], 201);
    }

    // Fetch all blog posts
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);

        return response()->json([
            'message' => 'Blogs fetched successfully',
            'blogs' => $blogs
        ], 200);
    }

    // Fetch a single blog post by ID
    public function show($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        return response()->json([
            'message' => 'Blog fetched successfully',
            'blog' => $blog
        ], 200);
    }

    // Update an existing blog post
    public function update(Request $request, $id)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the blog post
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        // Update fields if provided
        if ($request->has('title')) {
            $blog->title = $request->title;
        }

        if ($request->has('description')) {
            $blog->description = $request->description;
        }

        // Handle image update if exists
        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('images', 'public');
            $blog->image = $imagePath;
        }

        $blog->save();

        return response()->json([
            'message' => 'Blog updated successfully!',
            'blog' => $blog
        ], 200);
    }

    // Delete a blog post
    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        // Delete associated image
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully!'], 200);
    }
}
