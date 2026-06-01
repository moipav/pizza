<?php declare(strict_types=1);

use App\Http\Controllers\Api\V1\Admin\ProductSizeController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\ProductController;
use App\Http\Controllers\Api\V1\Admin\UserStatusController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CartItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#Маршруты объединяем если понадобится версионирование
Route::prefix('v1')->group(function () {
    #Админ
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('product_sizes', ProductSizeController::class);
        Route::apiResource('statuses', UserStatusController::class);

    });
    #Корзина
    #Корзина (операции с самой корзиной)
    Route::prefix('cart')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('api.cart.index');
        Route::delete('/', 'clear')->name('api.cart.clear');
    });

    #Элементы корзины (отдельный контроллер)
    Route::prefix('cart/items')->controller(CartItemController::class)->group(function () {
        Route::post('/', 'store')->name('api.cart.items.store');
        Route::put('/{cartItem}', 'update')->name('api.cart.items.update');
        Route::delete('/{cartItem}', 'destroy')->name('api.cart.items.destroy');
    });
    #login

    Route::post('register', [\App\Http\Controllers\Api\V1\Auth\RegisterController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'logout'])->middleware('auth:sanctum');
});


