<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

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
}

