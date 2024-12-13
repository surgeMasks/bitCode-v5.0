<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function() {
    Route::post('/register', 'register')->name('register');

    Route::post('/login', 'login')->name('login')->middleware('throttle:10,5');
    Route::post('/logout', 'logout')->name('logout')->middleware(['auth:sanctum']);
});

Route::group(['middleware'=>['auth:sanctum']], function(){

    Route::controller(UserController::class)->group(function() {
            Route::get('/user', 'show');
            Route::put('/user', 'update');
            Route::patch('/user', 'patch');
            Route::post('/user/delete', 'destroy');
        });
});
