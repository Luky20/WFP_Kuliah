<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FoodController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('kategori', CategoryController::class);

Route::resource('food', FoodController::class);