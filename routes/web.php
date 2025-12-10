<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo "hello from laravel!";

});

Route::resource('users', \App\Http\Controllers\UserController::class);

Route::get('/statuses', [\App\Http\Controllers\UserStatusController::class, 'index']);
