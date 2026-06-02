<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoricalFigure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FigureController extends Controller
{
    public function index()
    {
        $figures = HistoricalFigure::with('translations')->latest()->paginate(20);
        return view('admin.figures.index', compact('figures'));
    }

    public function create()
    {
        return view('admin.figures.form', ['figure' => null]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $this->figureData($request);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('uploads/featured', 'public');
        }

        $figure = HistoricalFigure::create($data);
        $this->saveTranslations($figure, $request);
        return redirect()->route('admin.figures.index')->with('success', 'Figure created.');
    }

    public function show(HistoricalFigure $figure)
    {
        return redirect()->route('admin.figures.edit', $figure);
    }

    public function edit(HistoricalFigure $figure)
    {
        $figure->load('translations');
        return view('admin.figures.form', compact('figure'));
    }

    public function update(Request $request, HistoricalFigure $figure)
    {
        $this->validateRequest($request);
        $data = $this->figureData($request);

        if ($request->hasFile('featured_image')) {
            if ($figure->featured_image) Storage::disk('public')->delete($figure->featured_image);
            $data['featured_image'] = $request->file('featured_image')->store('uploads/featured', 'public');
        } elseif ($request->boolean('remove_image') && $figure->featured_image) {
            Storage::disk('public')->delete($figure->featured_image);
            $data['featured_image'] = null;
        }

        $figure->update($data);
        $this->saveTranslations($figure, $request);
        return redirect()->route('admin.figures.index')->with('success', 'Figure updated.');
    }

    public function destroy(HistoricalFigure $figure)
    {
        if ($figure->featured_image) {
            Storage::disk('public')->delete($figure->featured_image);
        }
        $figure->delete();
        return redirect()->route('admin.figures.index')->with('success', 'Figure deleted.');
    }

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'slug'          => ['required', 'string', 'max:200'],
            'en_name'       => ['required', 'string', 'max:200'],
            'featured_image'=> ['nullable', 'image', 'max:5120'],
        ]);
    }

    private function figureData(Request $request): array
    {
        return [
            'slug'         => Str::slug($request->slug),
            'born'         => $request->born,
            'died'         => $request->died,
            'era'          => $request->era,
            'region'       => $request->region,
            'category'     => $request->category,
            'is_published' => $request->boolean('is_published'),
        ];
    }

    private function saveTranslations(HistoricalFigure $figure, Request $request): void
    {
        foreach (['en', 'hi'] as $locale) {
            $name = $request->input("{$locale}_name");
            if (!$name) continue;

            // Quotes entered as one-per-line plain text
            $quotesRaw = $request->input("{$locale}_quotes_raw", '');
            $quotes    = array_values(array_filter(array_map('trim', explode("\n", $quotesRaw))));

            $figure->translations()->updateOrCreate(['locale' => $locale], [
                'name'             => $name,
                'title'            => $request->input("{$locale}_title"),
                'short_bio'        => $request->input("{$locale}_short_bio"),
                'full_bio'         => $request->input("{$locale}_full_bio"),
                'achievements'     => $request->input("{$locale}_achievements"),
                'quotes'           => $quotes ?: null,
                'meta_title'       => $request->input("{$locale}_meta_title"),
                'meta_description' => $request->input("{$locale}_meta_description"),
            ]);
        }
    }
}
