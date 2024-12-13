<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function() {
    Route::post('/register', 'register')->name('register');

    Route::post('/login', 'login')->name('login')->middleware('throttle:5,5');
    Route::post('/logout', 'logout')->name('logout')->middleware(['auth:sanctum']);
});
