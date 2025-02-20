<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
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

    public function index()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

}
