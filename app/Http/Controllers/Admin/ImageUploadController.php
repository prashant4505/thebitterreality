<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function store(Request $request): JsonResponse|Response
    {
        $request->validate([
            'upload' => ['required', 'file', 'image', 'max:5120', 'mimes:jpg,jpeg,png,webp,gif'],
        ]);

        $path = $request->file('upload')->store('uploads/content', 'public');
        $url  = asset('storage/' . $path);

        // CKEditor 4 filebrowserUploadUrl (iframe-based dialog)
        if ($request->filled('CKEditorFuncNum')) {
            $fn = (int) $request->input('CKEditorFuncNum');
            return response("<script>window.parent.CKEDITOR.tools.callFunction({$fn},'{$url}','');</script>");
        }

        // CKEditor 4 uploadimage plugin / CKEditor 5 format
        return response()->json([
            'uploaded' => 1,
            'fileName' => basename($path),
            'url'      => $url,
        ]);
    }
}
