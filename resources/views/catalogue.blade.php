@extends('layouts.app')

@section('title', 'Catalogue')

@section('content')
<div x-data="catalogue()" x-init="loadAll()" class="space-y-6">

    <!-- Header & Controls -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <h1 class="text-2xl font-bold">Product Catalogue</h1>

        <div class="flex gap-2 flex-wrap">
            <!-- Search -->
            <input type="text" x-model="search" @input="filterProducts"
                   placeholder="Search products..."
                   class="border px-3 py-1 rounded-lg text-sm">

            <!-- Category Filter -->
            <select x-model="selectedCategory" @change="filterProducts"
                    class="border px-3 py-1 rounded-lg text-sm">
                <option value="">All Categories</option>
                <template x-for="cat in categories" :key="cat.id">
                    <option :value="cat.id" x-text="cat.category_name"></option>
                </template>
            </select>

            <!-- Toggle View -->
            <button @click="isGrid = !isGrid"
                    class="border rounded-lg px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200">
                <span x-text="isGrid ? 'Table View' : 'Grid View'"></span>
            </button>

            <!-- Add Product -->
            <button @click="showAddModal = true"
                    class="bg-gray-200 text-sky-700 px-4 py-1 rounded-lg hover:bg-sky-100 text-sm transition">
                <i class="ri-add-circle-fill ri-lg"></i>
             Add Product    
        </button>
        </div>
    </div>

    <!-- Grid View -->
    <template x-if="isGrid">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-2">
            <template x-for="product in filteredProducts" :key="product.id">

                <div class="bg-white border rounded-xl p-4 shadow hover:shadow-lg transition">
                    <h2 class="text-lg font-semibold" x-text="product.name"></h2>
                    <p class="text-sm text-gray-500" x-text="'Category: ' + (product.category?.category_name || '-')"></p>
                    <p class="mt-2 text-sm" x-text="product.description || 'No description'"></p>
                    <p class="mt-4 font-bold text-sky-600" x-text="formatPrice(product.price)"></p>
                </div>

            </template>
        </div>
    </template>

    <!-- Table View -->
    <template x-if="!isGrid">
        <div class="overflow-x-auto border rounded-xl bg-white">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-2">Name</th>
                        <th class="text-left px-4 py-2">Category</th>
                        <th class="text-left px-4 py-2">Price</th>
                        <th class="text-left px-4 py-2">Description</th>
                        <th class="text-left px-4 py-2">Actions</th> <!-- New column -->
                    </tr>
                </thead>
                <tbody>
                    <template x-for="product in filteredProducts" :key="product.id">
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2" x-text="product.name"></td>
                            <td class="px-4 py-2" x-text="product.category?.category_name || 'N/A'"></td>
                            <td class="px-4 py-2" x-text="formatPrice(product.price)"></td>
                            <td class="px-4 py-2" x-text="product.description || '-'"></td>
                            <td class="px-4 py-2 flex gap-2">
                                <a @click="editProduct(product)"
                                class="flex justify-center p-2 bg-gray-100 text-black hover:bg-gray-300 text-md rounded-md min-w-16 transition">
                                <i class="ri-edit-box-fill"></i> Edit</a>

                                <button @click="deleteProduct(product.id)"
                                class="flex justify-center p-2 bg-gray-100 text-red-600 rounded-md hover:bg-red-200 text-md min-w-16 transition">
                                <i class="ri-delete-bin-fill"></i> Delete</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </template>


    <!-- Add Product Modal -->
    <div
        x-show="showAddModal"
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        style="margin:0 !important; padding:0 !important;"
        >
        <div class="bg-white w-full max-w-md rounded-xl p-6 space-y-4 shadow-xl"
             @click.away="showAddModal = false">
            <h2 class="text-lg font-bold">Add New Product</h2>

            <div class="space-y-2">
                <input type="text" placeholder="Product Name" x-model="form.name"
                       class="w-full border px-3 py-2 rounded" />

                <select x-model="form.category_id" class="w-full border px-3 py-2 rounded">
                    <option value="">Select Category</option>
                    <template x-for="cat in categories" :key="cat.id">
                        <option :value="cat.id" x-text="`${cat.category_name} (${cat.category_abbreviation})`"></option>
                    </template>
                </select>


                <input type="number" placeholder="Price (USD)" x-model="form.price"
                       class="w-full border px-3 py-2 rounded" />

                <textarea placeholder="Description" x-model="form.description"
                          class="w-full border px-3 py-2 rounded"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button class="px-4 py-2 text-sm text-gray-600" @click="showAddModal = false">Cancel</button>
                <button class="px-4 py-2 bg-sky-600 text-white rounded text-sm"
                        @click="submitForm">Add</button>
            </div>
        </div>
    </div>
</div>

<script>

    function formatPrice(value) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(value);
}

    function catalogue() {

        return {
            products: [],
            filteredProducts: [],
            categories: [],
            search: '',
            selectedCategory: '',
            isGrid: false,
            showAddModal: false,
            form: {
                name: '',
                category_id: '',
                price: '',
                description: ''
            },

            async loadAll() {
                const [productsRes, categoriesRes] = await Promise.all([
                    fetch('/products'),
                    fetch('/categories')
                ]);
                this.products = await productsRes.json();
                this.categories = await categoriesRes.json();
                this.filterProducts();
            },

            filterProducts() {
                this.filteredProducts = this.products.filter(p => {
                    const matchCategory = !this.selectedCategory || p.category_id == this.selectedCategory;
                    const matchSearch = !this.search || p.name.toLowerCase().includes(this.search.toLowerCase());
                    return matchCategory && matchSearch;
                });
            },

            async submitForm() {
                const method = this.isEditing ? 'PUT' : 'POST';
                const url = this.isEditing ? `/products/${this.form.id}` : '/products';

                const res = await fetch(url, {
                    method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form)
                });

                if (res.ok) {
                    const response = await res.json();

                    if (this.isEditing) {
                        const index = this.products.findIndex(p => p.id === this.form.id);
                        if (index !== -1) this.products[index] = response.data;
                    } else {
                        this.products.push(response.data);
                    }

                    this.filterProducts();
                    this.showAddModal = false;
                    this.isEditing = false;
                    this.form = { name: '', category_id: '', price: '', description: '' };
                } else {
                    alert("Failed to save product.");
                }
            },

            editProduct(product) {
                this.form = { ...product };
                this.isEditing = true;
                this.showAddModal = true;
            },

            async deleteProduct(id) {
                if (!confirm("Are you sure you want to delete this product?")) return;

                const res = await fetch(`/products/${id}`, {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' }
                });

                if (res.ok) {
                    this.products = this.products.filter(p => p.id !== id);
                    this.filterProducts();
                } else {
                    alert("Failed to delete product.");
                }
            },

        }
    }
</script>
@endsection

