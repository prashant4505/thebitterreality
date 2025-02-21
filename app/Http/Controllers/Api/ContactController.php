<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Store a new contact message
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'description' => 'required|string',
        ]);

        $message = ContactMessage::create($request->all());

        return response()->json([
            'message' => 'Your message has been sent successfully!',
            'data' => $message
        ], 201);
    }

    // Fetch all contact messages (paginated)
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(10);

        return response()->json([
            'message' => 'Contact messages fetched successfully',
            'data' => $messages
        ], 200);
    }

    // Fetch a single contact message by ID
    public function show($id)
    {
        $message = ContactMessage::find($id);

        if (!$message) {
            return response()->json([
                'message' => 'Message not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Message fetched successfully',
            'data' => $message
        ], 200);
    }

    // Delete a contact message
    public function destroy($id)
    {
        $message = ContactMessage::find($id);

        if (!$message) {
            return response()->json([
                'message' => 'Message not found'
            ], 404);
        }

        $message->delete();

        return response()->json([
            'message' => 'Message deleted successfully'
        ], 200);
    }
}
