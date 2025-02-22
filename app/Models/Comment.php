<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',  // ✅ Allow mass assignment of blog_id
        'name',
        'comment',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
