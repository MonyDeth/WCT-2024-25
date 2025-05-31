<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


// Route::get('/', function () {
//     return view('login'); // login.blade.php
// })->name('login');

Route::get('/', function () {
    return view('welcome'); // login.blade.php
});

// Show register form
Route::get('/register', function () {
    return view('register'); // This is your register.blade.php
})->name('register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');



Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');




// Categories CRUD
Route::get('/categories', [CategoryController::class, 'index']);      // List all categories
Route::post('/categories', [CategoryController::class, 'store']);     // Create category
Route::get('/categories/{id}', [CategoryController::class, 'show']);  // Get single category
Route::put('/categories/{id}', [CategoryController::class, 'update']); // Update category
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']); // Delete category

// Products CRUD
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
