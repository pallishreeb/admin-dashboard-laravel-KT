<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'user_name', 'mobile', 'email', 'query_message'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
