@extends('layouts.app')

@section('title', 'Sale Orders')

@section('content')
<div class="space-y-4">
    <h1 class="text-2xl font-bold">Sale Orders</h1>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Subtotal</th>
                    <th class="px-4 py-2">Discount</th>
                    <th class="px-4 py-2">Grand Total</th>
                    <th class="px-4 py-2">Payment Method</th>
                    <th class="px-4 py-2">Created At</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saleOrders as $order)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $order->id }}</td>
                    <td class="px-4 py-2">{{ number_format($order->subtotal, 2) }}</td>
                    <td class="px-4 py-2">{{ number_format($order->discount, 2) }}</td>
                    <td class="px-4 py-2 font-semibold">{{ number_format($order->grand_total, 2) }}</td>
                    <td class="px-4 py-2">{{ $order->paymentMethod->method_name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('sale-orders.show', $order->id) }}" class=" gap-2 py-1 border items-center justify-center p-1 px-2 bg-gray-100 text-black hover:bg-gray-300 rounded-md transition">
                        <i class="ri-eye-line"></i>
                        View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
