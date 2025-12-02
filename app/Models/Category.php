<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function restaurants()
    {
        return $this->hasManyThrough(Restaurant::class, MenuItem::class, 'category_id', 'id', 'id', 'restaurant_id');
    }
}
