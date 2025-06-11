@extends('layouts.app')
@section('title', 'Point of Sales')
@section('content')
<div class="flex gap-6 text-gray-800 flex-grow h-full" x-data="posCart()">
	<!-- Left: Product Grid -->
	<div class="w-2/3">
		<h1 class="text-2xl font-bold mb-4">Point of Sales</h1>
		<div class="flex gap-2 mb-4 items-center">
			<!-- Search input with icon -->
			<div class="relative w-60">
				<input
					type="text"
					placeholder="Search"
					class="w-full pl-8 pr-2 py-2 border border-gray-300 rounded-xl shadow hover:bg-gray-100 transition"
					x-model="searchQuery"
				/>
				<i class="ri-search-line absolute left-2 top-1/2 -translate-y-1/2 text-gray-400"></i>
			</div>

			<!-- Barcode input with icon -->
			<div class="relative w-40 ">
				<input
					type="text"
					placeholder="Barcode"
					class="w-full pl-8 pr-2 py-2 border border-gray-300 rounded-xl shadow hover:bg-gray-100 transition"
					x-model="barcodeQuery"
				/>
				<i class="ri-barcode-line absolute left-2 top-1/2 -translate-y-1/2 text-gray-400"></i>
			</div>
		</div>

		<div class="grid grid-cols-4 gap-2">
			<template x-for="product in filteredProducts()" :key="product.id">
                <div
                    class="flex items-center gap-4 bg-white border p-3 rounded-2xl cursor-pointer hover:bg-gray-100 transition hover:scale-105"
                    @click="addToCart({ id: product.id, name: product.name, price: Number(product.price), qty: 1 })"
                >
                    <!-- Image box -->
                    <div class="w-24 h-24 bg-gray-200 rounded-md flex-shrink-0"></div>

                    <!-- Text content -->
                    <div>
                        <div class="text-sm font-semibold" x-text="product.name"></div>
                        <div class="text-sm">$<span x-text="Number(product.price).toFixed(2)"></span></div>
                    </div>
                </div>
            </template>


		</div>
	</div>

	<!-- Right: Cart -->
	<div class="w-1/3 bg-white p-4 rounded-xl shadow-xl flex flex-col border border-gray-200 overflow-hidden" style="border-radius: 1.5rem;">
	<!-- Header -->
	<div class="flex justify-between items-center mb-2">
		<h2 class="text-lg font-bold">Cart</h2>
		<div class="flex gap-2 border border-gray-200 p-1 rounded-md shadow-md hover:bg-red-100 hover:text-red-200 hover:shadow-sm transition">
			<button class="text-sm text-gray-600" @click="clearCart">Clear Cart <i class="ri-delete-bin-line mr-1"></i></button>
		</div>
	</div>

	<!-- Cart Items Scrollable Section -->
	<div class="flex-1 min-h-0 overflow-y-hidden space-y-2 pr-1">
		<template x-for="item in cart" :key="item.id">
			<div class="animate-[wiggle_1s_ease-in-out_infinite] flex justify-between items-center p-2 border rounded-lg bg-white shadow-sm hover:bg-gray-50 transition">
				<div class="flex items-center gap-2">
					<div class="w-10 h-10 bg-gray-200 rounded"></div>
					<div>
						<div class="text-sm font-semibold" x-text="item.name"></div>
						<div class="text-xs text-gray-500">$<span x-text="(item.price * item.qty).toFixed(2)"></span></div>
					</div>
				</div>

				<div class="flex items-center gap-2">
					<button @click="updateQty(item.id, item.qty + 1)" class="px-2 bg-gray-200 w-8 h-8 hover:scale-110 rounded-full transition">
						<i class="ri-add-circle-line"></i>
					</button>

					<span class="text-md" x-text="item.qty"></span>

					<button
						class="px-2 hover:scale-110 hover:bg-red-200 bg-gray-200 w-8 h-8 rounded-full transition"
						@click="
							if (item.qty === 1) {
								cart = cart.filter(p => p.id !== item.id);
							} else {
								updateQty(item.id, item.qty - 1);
							}
						"
					>
						<template x-if="item.qty === 1">
							<i class="ri-delete-bin-line text-red-400"></i>
						</template>
						<template x-if="item.qty > 1">
							<i class="ri-indeterminate-circle-line"></i>
						</template>
					</button>
				</div>
			</div>
		</template>
	</div>

	<!-- Totals and Payment Section -->
	<div class="pt-2 p-4 border border-gray-200 rounded-xl mt-2 shrink-0">
		<div class="flex justify-between text-sm">
			<span>Sub total</span>
			<span>$<span x-text="subtotal.toFixed(2)"></span></span>
		</div>
		<div class="flex justify-between text-sm">
			<span>
				Discount
				<button class="px-4 py-1 ms-2 border rounded-md shadow-sm text-gray-600 hover:bg-gray-100 transition" @click="editingDiscount = !editingDiscount">Edit</button>
			</span>
			<span x-text="discountPercentage + '% (-$' + discountAmount.toFixed(2) + ')'"></span>
		</div>
		<div x-show="editingDiscount" class="mt-2">
			<input type="number" class="w-full p-1 border rounded-md shadow-sm" x-model="discountPercentage" />
		</div>
		<div class="text-lg font-bold flex justify-between mt-1">
			<span>Grand Total</span>
			<span>$<span x-text="grandTotal.toFixed(2)"></span></span>
		</div>

		<div class="mt-4">
			<label class="block text-sm mb-2 font-medium">Payment Method</label>
			<div class="grid grid-cols-3 gap-2 h-10">
				<!-- Cash -->
				<div
					class="flex flex-col items-center justify-center gap-1 text-sm text-center border border-gray-200 p-2 rounded-md shadow cursor-pointer transition hover:bg-gray-100"
					:class="paymentMethodId === 'cash' ? 'border-2 border-black font-semibold bg-gray-50' : ''"
					@click="paymentMethodId = 'cash'"
				>
					<i class="ri-cash-line ri-2x"></i>
				</div>

				<!-- KHQR -->
				<div
					class="flex flex-col items-center justify-center gap-1 text-sm text-center border border-gray-200 p-2 rounded-md shadow cursor-pointer transition hover:bg-gray-100"
					:class="paymentMethodId === 'khqr' ? 'border-2 border-black font-semibold bg-gray-50' : ''"
					@click="paymentMethodId = 'khqr'"
				>
					<img src="{{ asset('images/khqr.png') }}" class="h-4 w-auto filter grayscale contrast-125 saturate-50" alt="KHQR" />
				</div>

				<!-- Credit Card -->
				<div
					class="flex flex-col items-center justify-center gap-1 text-sm text-center border border-gray-200 p-2 rounded-md shadow cursor-pointer transition hover:bg-gray-100"
					:class="paymentMethodId === 'credit' ? 'border-2 border-black font-semibold bg-gray-50' : ''"
					@click="paymentMethodId = 'credit'"
				>
					<i class="ri-bank-card-line ri-2x"></i>
				</div>
			</div>
		</div>

		<button class="w-full bg-black text-white mt-4 p-2 rounded-md hover:bg-gray-900" @click="checkout">
			Check Out
		</button>
	</div>
</div>

</div>

</div>

<script>
	function posCart() {
	    return {
	        searchQuery: '',
	        barcodeQuery: '',

	        cart: [],
	        discountPercentage: 0,
	        editingDiscount: false,
	        paymentMethodId: '',

	        products: @json($products),

	        get subtotal() {
	            return this.cart.reduce((sum, item) => sum + item.price * item.qty, 0);
	        },
	        get discountAmount() {
	            return (this.discountPercentage / 100) * this.subtotal;
	        },
	        get grandTotal() {
	            return this.subtotal - this.discountAmount;
	        },

            filteredProducts() {
                const term = this.searchQuery.toLowerCase().trim();
                if (!term) return this.products;
                return this.products.filter(product =>
                    product.name.toLowerCase().includes(term)
                    || (product.barcode || '').toLowerCase().includes(term)
                );
            },

	        addToCart(product) {
	            const existing = this.cart.find(p => p.id === product.id);
	            if (existing) {
	                this.updateQty(existing.id, existing.qty + 1);
	            } else {
	                this.cart = [...this.cart, { ...product }];
	            }
	        },

	        updateQty(id, qty) {
	            if (qty < 1) {
	                this.cart = this.cart.filter(p => p.id !== id);
	            } else {
	                this.cart = this.cart.map(p => p.id === id ? { ...p, qty } : p);
	            }
	        },

	        clearCart() {
	            this.cart = [];
	        },

	        checkout() {
	            if (!this.paymentMethodId) {
	                alert("Please select a payment method.");
	                return;
	            }

	            const methodMap = {
	                cash: 1,
	                khqr: 2,
	                credit: 3
	            };

	            fetch('/pos/checkout', {
	                method: 'POST',
	                headers: {
	                    'Content-Type': 'application/json',
	                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
	                },
	                body: JSON.stringify({
	                    items: this.cart,
	                    discount: this.discountPercentage,
	                    payment_method_id: methodMap[this.paymentMethodId]
	                })
	            })
	            .then(res => res.json())
	            .then(data => {
	                if (data.success) {
	                    alert('Checkout successful!');
	                    this.clearCart();
	                    this.paymentMethodId = '';
	                } else {
	                    alert('Checkout failed.');
	                }
	            })
	            .catch(err => {
	                console.error(err);
	                alert('An error occurred during checkout.');
	            });
	        }
	    };
	}
</script>
@endsection
