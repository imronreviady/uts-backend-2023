<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    
    protected $table = 'category';
    protected $fillable = [
        'name',
        'slug',
    ];

    public function news()
    {
        return $this->hasMany(News::class, 'category', 'slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
