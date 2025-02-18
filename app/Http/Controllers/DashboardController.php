<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $userCount = User::count(); // Get the total user count
        $blogCount = Blog::count();
        $jokesCount = Post::count();
        return view('dashboard', compact('userCount', 'blogCount', 'jokesCount')); // Pass the user count to the view
    }
}
