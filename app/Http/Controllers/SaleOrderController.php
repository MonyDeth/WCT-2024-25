<?php

namespace App\Http\Controllers;

use App\Models\SaleOrder;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class SaleOrderController extends Controller
{
    public function index(Request $request)
    {
        $saleOrders = SaleOrder::with('paymentMethod')->latest()->get();

        if ($request->expectsJson()) {
            // Return JSON for API calls
            return response()->json($saleOrders);
        }

        // Return view for web/browser requests
        return view('sale_orders', compact('saleOrders'));
    }


        public function show(Request $request, $id)
    {
        $order = SaleOrder::with(['paymentMethod', 'items.product'])->findOrFail($id);

        if ($request->expectsJson()) {
            return response()->json($order);
        }

        return view('sale_order_detail', compact('order'));
    }



}
