<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Post;
use App\Models\User;
use App\Models\ContactMessage;
use App\Models\DeepThought;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $userCount = User::count(); // Get the total user count
        $blogCount = Blog::count();
        $jokesCount = Post::count();
        $contactMessage = ContactMessage::count();
        $totalThoughts = DeepThought::count();
        return view('dashboard', compact('userCount', 'blogCount', 'jokesCount', 'contactMessage', 'totalThoughts')); // Pass the user count to the view
    }
}
