<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricalFigureTranslation extends Model
{
    protected $fillable = [
        'historical_figure_id', 'locale', 'name', 'title', 'short_bio',
        'full_bio', 'achievements', 'quotes', 'meta_title', 'meta_description',
    ];

    protected $casts = ['quotes' => 'array'];

    public function figure(): BelongsTo
    {
        return $this->belongsTo(HistoricalFigure::class, 'historical_figure_id');
    }
}
