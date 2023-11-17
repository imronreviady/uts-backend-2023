<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';
    protected $fillable = [
        'title',
        'author',
        'description',
        'content',
        'url',
        'url_image',
        'published_at',
        'category',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
