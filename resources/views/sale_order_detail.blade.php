@extends('layouts.app')

@section('title', 'Sale Order Details')

@section('content')
<h2>Sale Order #{{ $order->id }}</h2>
<p>Date: {{ $order->created_at->format('Y-m-d H:i') }}</p>
<p>Payment Method: {{ $order->paymentMethod->method_name ?? 'N/A' }}</p>

<table class="min-w-full text-sm mt-4">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 text-left">Product</th>
            <th class="px-4 py-2 text-left">Quantity</th>
            <th class="px-4 py-2 text-left">Price</th>
            <th class="px-4 py-2 text-left">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->items as $item)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-2">{{ $item->product->name ?? 'Unknown Product' }}</td>
                <td class="px-4 py-2">{{ $item->quantity }}</td>
                <td class="px-4 py-2">${{ number_format($item->price, 2) }}</td>
                <td class="px-4 py-2">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    <p>Subtotal: ${{ number_format($order->subtotal, 2) }}</p>
    <p>Discount: ${{ number_format($order->discount, 2) }}</p>
    <p class="font-bold">Grand Total: ${{ number_format($order->grand_total, 2) }}</p>
</div>


<a href="{{ route('sale-orders.index') }}" class="mt-6 inline-block text-blue-600 hover:underline">Back to list</a>
@endsection
