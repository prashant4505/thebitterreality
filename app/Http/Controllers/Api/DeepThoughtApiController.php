<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeepThought;

class DeepThoughtApiController extends Controller
{
    public function index()
    {
        $thoughts = DeepThought::with('user:id,name') // Fetch user ID & name
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'content', 'user_id', 'created_at']);

        return response()->json($thoughts);
    }
}
