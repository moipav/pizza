<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserStatusController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

#Думаю потом придется разобрать эти роуты, для ограничения доступа к их редактированию

//Главная страница

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class);

//корзина
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/items', [CartItemController::class, 'store'])->name('cart.items.store');
Route::put('/cart/items/{cartItem}', [CartItemController::class, 'update'])->name('cart.items.update');
Route::delete('/cart/items/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.items.destroy');


//Оформление заказа
Route::get('/orders/index', [OrderController::class, 'index'])->name('orders.index');//->middleware('auth');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

//Админ часть
Route::resource('statuses', UserStatusController::class);
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('product-sizes', ProductSizeController::class);

#Регистрация
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
    Route::post('/register', [RegisterController::class, 'register']);
#login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});


#logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

