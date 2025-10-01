<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('kategori', CategoryController::class);

Route::resource('food', FoodController::class);


Route::get('/latihan', fn () => redirect()->route('latihan.show', ['num' => 1]));

Route::get('/latihan/{num?}', [ReportController::class, 'show'])
    ->whereNumber('num')
    ->name('latihan.show');