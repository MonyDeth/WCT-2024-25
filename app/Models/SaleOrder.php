<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'subtotal',
        'discount',
        'grand_total',
        'payment_method_id',
    ];

    public function items()
    {
        return $this->hasMany(SaleOrderItem::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
