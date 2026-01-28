<?php

use Illuminate\Support\Facades\Route;

#Думаю потом придется разобрать эти роуты, для ограничения доступа к их редактированию
Route::get('/', function () {
    dd(\Illuminate\Support\Facades\Session::getId());
});
Route::resource('users', \App\Http\Controllers\UserController::class);
Route::resource('statuses', \App\Http\Controllers\UserStatusController::class);
Route::resource('products', \App\Http\Controllers\ProductController::class);
Route::resource('categories', \App\Http\Controllers\CategoryController::class);
Route::resource('product-sizes', \App\Http\Controllers\ProductSizeController::class);
