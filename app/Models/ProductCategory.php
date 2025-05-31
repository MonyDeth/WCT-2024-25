<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ['category_name', 'category_abbreviation', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}

