<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle(Request $request, string $category, string $slug): JsonResponse
    {
        $topic = Topic::published()
            ->whereHas('category', fn($q) => $q->where('slug', $category))
            ->where('slug', $slug)
            ->firstOrFail();

        $sessionId = session()->getId();
        $bookmark = Bookmark::where('topic_id', $topic->id)
            ->where('session_id', $sessionId)->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['bookmarked' => false]);
        }

        Bookmark::create(['topic_id' => $topic->id, 'session_id' => $sessionId]);
        return response()->json(['bookmarked' => true]);
    }
}
