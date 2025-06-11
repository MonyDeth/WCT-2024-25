<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // add DB facade
use App\Models\Product;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pos', compact('products'));
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0|max:100',
            'payment_method_id' => 'required|integer|in:1,2,3',
        ]);

        // Calculate subtotal from items server-side for security
        $subtotal = 0;
        foreach ($data['items'] as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $discountAmount = ($data['discount'] / 100) * $subtotal;
        $grandTotal = $subtotal - $discountAmount;

        // Wrap in DB transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // Insert sale_order and get inserted ID
            $orderId = DB::table('sale_orders')->insertGetId([
                'subtotal' => $subtotal,
                'discount' => $discountAmount,
                'grand_total' => $grandTotal,
                'payment_method_id' => $data['payment_method_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Prepare sale_order_items data
            $orderItems = [];
            foreach ($data['items'] as $item) {
                $orderItems[] = [
                    'sale_order_id' => $orderId,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert all items at once
            DB::table('sale_order_items')->insert($orderItems);

            DB::commit();

            return response()->json(['success' => true, 'order_id' => $orderId]);

        } catch (\Exception $e) {
            DB::rollBack();
            // Optionally log error
            return response()->json(['success' => false, 'message' => 'Checkout failed.'], 500);
        }
    }
}
