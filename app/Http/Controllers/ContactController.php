<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'description' => 'required|string',
        ]);

        ContactMessage::create($request->all());

        return redirect()->route('contact.show')->with('success', 'Your message has been sent successfully!');
    }

    public function index()
    {
        $messages = ContactMessage::latest()->paginate(10);
        return view('contact.index', compact('messages'));
    }

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        return view('contact.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        // Ensure only the owner or an admin can delete
        if (Auth::check()) {
            $message->delete();
            return back()->with('success', 'Contact Us message deleted successfully.');
        }
        
        return back()->with('error', 'You are not authorized to delete this contact.');
    }

}

