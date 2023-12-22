<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'parentcategory_id', 'status', 'rank'];

    // Define relationships if necessary
    public function category()
    {
        return $this->belongsTo(Category::class, 'parentcategory_id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }
}
