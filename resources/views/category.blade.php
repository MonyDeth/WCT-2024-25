@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div x-data="categoryPage()" x-init="loadCategories()" class="space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Product Categories</h1>

        <button @click="showAddModal = true"
                class="bg-gray-200 text-sky-700 px-4 py-1 rounded-lg hover:bg-sky-100 text-sm transition">
                <i class="ri-add-circle-fill ri-lg"></i>
             Add Category
        </button>
    </div>

    <!-- Table View -->
    <div class="overflow-x-auto border rounded-xl bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-4 py-2">Category Name</th>
                    <th class="text-left px-4 py-2">Abbreviation</th>
                    <th class="text-left px-4 py-2">Description</th>
                    <th class="text-left px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="cat in filteredCategories" :key="cat.id">
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2" x-text="cat.category_name"></td>
                        <td class="px-4 py-2" x-text="cat.category_abbreviation"></td>
                        <td class="px-4 py-2" x-text="cat.description || '-'"></td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="javascript:void(0)"
                               @click="editCategory(cat)"
                               class="flex items-center justify-center p-2 bg-gray-100 text-black hover:bg-gray-300 rounded-md min-w-[64px] transition">
                                <i class="ri-edit-box-fill mr-1"></i> Edit
                            </a>

                            <button @click="deleteCategory(cat.id)"
                                    class="flex items-center justify-center p-2 bg-gray-100 text-red-600 rounded-md hover:bg-red-200 min-w-[64px] transition">
                                <i class="ri-delete-bin-fill mr-1"></i> Delete
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Add/Edit Category Modal -->
    <div
        x-show="showAddModal"
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        style="margin:0 !important; padding:0 !important;"
        >
        <div class="bg-white w-full max-w-md rounded-xl p-6 space-y-4 shadow-xl"
             @click.away="showAddModal = false">
            <h2 class="text-lg font-bold" x-text="isEditingCategory ? 'Edit Category' : 'Add New Category'"></h2>

            <div class="space-y-2">
                <input type="text" placeholder="Category Name" x-model="categoryForm.category_name"
                       class="w-full border px-3 py-2 rounded" />
                <input type="text" placeholder="Category Abbreviation" x-model="categoryForm.category_abbreviation"
                       class="w-full border px-3 py-2 rounded" />
                <textarea placeholder="Description" x-model="categoryForm.description"
                          class="w-full border px-3 py-2 rounded"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button class="px-4 py-2 text-sm text-gray-600" @click="showAddModal = false">Cancel</button>
                <button class="px-4 py-2 bg-sky-600 text-white rounded text-sm"
                        @click="submitCategoryForm()">Save</button>
            </div>
        </div>
    </div>

</div>

<script>
    function categoryPage() {
        return {
            categories: [],
            filteredCategories: [],
            showAddModal: false,
            isEditingCategory: false,
            categoryForm: {
                id: null,
                category_name: '',
                category_abbreviation: '',
                description: '',
            },

            async loadCategories() {
                const res = await fetch('/categories');
                this.categories = await res.json();
                this.filterCategories();
            },

            filterCategories() {
                // For now, no search/filter, just copy all
                this.filteredCategories = this.categories;
            },

            editCategory(cat) {
                this.categoryForm = {...cat};
                this.isEditingCategory = true;
                this.showAddModal = true;
            },

            async deleteCategory(id) {
                if (!confirm('Are you sure you want to delete this category?')) return;

                const res = await fetch(`/categories/${id}`, {
                    method: 'DELETE',
                    headers: {'Content-Type': 'application/json'},
                });

                if (res.ok) {
                    this.categories = this.categories.filter(c => c.id !== id);
                    this.filterCategories();
                    await this.loadCategories();
                } else {
                    alert('Failed to delete category.');
                }
            },

            async submitCategoryForm() {
                const method = this.isEditingCategory ? 'PUT' : 'POST';
                const url = this.isEditingCategory ? `/categories/${this.categoryForm.id}` : '/categories';

                const res = await fetch(url, {
                    method,
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(this.categoryForm),
                });

                if (res.ok) {
                    const data = await res.json();
                    if (this.isEditingCategory) {
                        const idx = this.categories.findIndex(c => c.id === this.categoryForm.id);
                        if (idx !== -1) this.categories.splice(idx, 1, data);
                    } else {
                        this.categories.push(data);
                    }
                    this.filterCategories();
                    await this.loadCategories();
                    this.showAddModal = false;
                    this.isEditingCategory = false;
                    this.categoryForm = { id: null, category_name: '', category_abbreviation: '', description: '' };

                } else {
                    alert('Failed to save category.');
                }
            },
        }
    }
</script>
@endsection
