<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'productId', 'name', 'description', 'category_id', 'subcategory_id', 'price', 'model', 'features',
        'brand', 'rank', 'active', 'isDeleted', 'status',
    ];

    protected $casts = [
        'features' => 'array'
    ];

    // Define relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
