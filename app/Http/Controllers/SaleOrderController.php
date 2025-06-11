<?php

namespace App\Http\Controllers;

use App\Models\SaleOrder;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class SaleOrderController extends Controller
{
    public function index()
    {
        $saleOrders = SaleOrder::with('paymentMethod')->latest()->get();
        return view('sale_orders', compact('saleOrders'));
    }

    public function show($id)
    {
        $order = SaleOrder::with(['paymentMethod', 'items.product'])->findOrFail($id);
        return view('sale_order_detail', compact('order'));
    }


}
