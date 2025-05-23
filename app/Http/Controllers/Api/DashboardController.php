<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Post;
use App\Models\User;
use App\Models\DeepThought;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data = [
            'user_count' => User::count(),
            'blog_count' => Blog::count(),
            'jokes_count' => Post::count(),
            'deep_thoughts' => DeepThought::count(),
            'contact_message_count' => ContactMessage::count(),
        ];

        return response()->json([
            'message' => 'Dashboard statistics fetched successfully',
            'data' => $data
        ], 200);
    }
}
