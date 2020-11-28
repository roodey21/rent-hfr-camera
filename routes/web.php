<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// ? ROUTE BRAND ADMIN
Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
Route::get('/brand/delete/{id}', [BrandController::class, 'destroy'])->name('brand.delete');
Route::get('/brand/detail/{id}', [BrandController::class, 'show'])->name('brand.detail');
Route::post('/brand/edit/{id}', [BrandController::class, 'update'])->name('brand.update');
// ? ROUTE CATEGORY ADMIN
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/getParent', [CategoryController::class, 'getParent'])->name('category.getParent');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
Route::get('/category/detail/{id}', [CategoryController::class, 'show'])->name('category.detail');
Route::post('/category/edit/{id}', [CategoryController::class, 'update'])->name('category.update');

// ? ROUTE PRODUCT ADMIN
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
// Route::get('/product/getParent', [ProductController::class, 'getParent'])->name('product.getParent');
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
Route::get('/product/detail/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::post('/product/edit/{id}', [ProductController::class, 'update'])->name('product.update');

Route::view('/test', 'test');
