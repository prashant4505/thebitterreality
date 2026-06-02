<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchTrend extends Model
{
    protected $fillable = ['query', 'count'];

    public static function record(string $query): void
    {
        static::updateOrCreate(['query' => $query], [])->increment('count');
    }
}
