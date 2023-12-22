<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type', 'status', 'rank'];

    // Define relationships if necessary
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'parentcategory_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
