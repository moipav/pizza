<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use Illuminate\Support\Facades\Route;

#Думаю потом придется разобрать эти роуты, для ограничения доступа к их редактированию

//Главная страница
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/cart/items', [CartItemController::class, 'store'])->name('cart.items.store');
Route::resource('users', \App\Http\Controllers\UserController::class);

//корзина
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/items', [CartItemController::class, 'store'])->name('cart.items.store');
Route::put('/cart/items/{cartItem}', [CartItemController::class, 'update'])->name('cart.items.update');
Route::delete('/cart/items/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.items.destroy');

//Route::post()
//Админ часть
Route::resource('statuses', \App\Http\Controllers\Admin\UserStatusController::class);
Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
Route::resource('product-sizes', \App\Http\Controllers\Admin\ProductSizeController::class);
