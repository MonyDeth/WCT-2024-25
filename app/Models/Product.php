<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'category_id', 'price', 'description'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function saleItems()
    {
        return $this->hasMany(SaleOrderItem::class);
    }
}

