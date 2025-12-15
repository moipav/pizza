<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo "hello from laravel!";
});

#Думаю потом придется разобрать эти роуты, для ограничения доступа к их редактированию
Route::resource('users', \App\Http\Controllers\UserController::class);
Route::resource('statuses', \App\Http\Controllers\UserStatusController::class);
//Route::get('/statuses', [\App\Http\Controllers\UserStatusController::class, 'index']);
