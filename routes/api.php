<?php

use App\Http\Controllers\Api\V1\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#Маршруты объединяем если понадобится версионирование
Route::prefix('v1')->group(function () {
    Route::apiResource('categories', CategoryController::class);
});
















Route::get('/user', function (Request $request) {
    $name = $request->get('name');
    return response()->json([
        'request' => $name,
        'test'=>'API it\'s work'
    ]);
//})->middleware('auth:sanctum');
});
