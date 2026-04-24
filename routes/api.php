<?php declare(strict_types=1);

use App\Http\Controllers\Api\V1\Admin\ProductSizeController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\ProductController;
use App\Http\Controllers\Api\V1\Admin\UserStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#Маршруты объединяем если понадобится версионирование
Route::prefix('v1')->/*middleware(['auth:sanctum'])->*/group(function () {
    #Админ
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('product_sizes', ProductSizeController::class);
    Route::apiResource('statuses', UserStatusController::class);


});
















Route::get('/user', function (Request $request) {
    $name = $request->get('name');
    return response()->json([
        'request' => $name,
        'test'=>'API it\'s work'
    ]);
//})->middleware('auth:sanctum');
});
