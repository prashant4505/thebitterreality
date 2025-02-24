<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeepThought;
use Illuminate\Support\Facades\Auth;

class DeepThoughtController extends Controller
{
    public function create()
    {
        return view('deep-thoughts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        DeepThought::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('deep-thoughts.create')->with('success', 'Deep Thought posted successfully!');
    }

    public function index()
    {
        $thoughts = DeepThought::with('user')->orderBy('created_at', 'desc')->get();
        return view('deep-thoughts.index', compact('thoughts'));
    }

    public function edit($id)
    {
        $thought = DeepThought::findOrFail($id);

        // Ensure only the owner can edit
        if ($thought->user_id !== Auth::id()) {
            return redirect()->route('deep-thoughts.index')->with('error', 'Unauthorized action.');
        }

        return view('deep-thoughts.edit', compact('thought'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $thought = DeepThought::findOrFail($id);

        // Ensure only the owner can update
        if ($thought->user_id !== Auth::id()) {
            return redirect()->route('deep-thoughts.index')->with('error', 'Unauthorized action.');
        }

        $thought->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('deep-thoughts.index')->with('success', 'Deep Thought updated successfully!');
    }

    public function destroy($id)
    {
        $thought = DeepThought::findOrFail($id);

        // Ensure only the owner can delete
        if ($thought->user_id !== Auth::id()) {
            return redirect()->route('deep-thoughts.index')->with('error', 'Unauthorized action.');
        }

        $thought->delete();

        return redirect()->route('deep-thoughts.index')->with('success', 'Deep Thought deleted successfully!');
    }


}

