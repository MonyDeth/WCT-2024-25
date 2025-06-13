<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\SaleOrderController;


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// PRODUCTS CRUD + search
Route::get('/products/search/{query}', function ($query) {
    return \App\Models\Product::where('name', 'LIKE', "%$query%")->get();
});
Route::apiResource('products', ProductController::class);

// CATEGORIES CRUD
Route::apiResource('categories', CategoryController::class);

Route::get('/hello', function () {
    return response()->json(['message' => 'API working']);
});
