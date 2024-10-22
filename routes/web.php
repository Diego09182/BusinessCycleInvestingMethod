<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/main', [MainController::class, 'index'])->name('main.index');
Route::get('/main/request', [MainController::class, 'request'])->name('main.request');
Route::get('/main/stock', [StockController::class, 'stock'])->name('stock.request');

Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
Route::post('/assets', [AssetController::class, 'store'])->name('assets.store');
Route::put('/assets/{id}', [AssetController::class, 'update'])->name('assets.update');
Route::delete('/assets/{id}', [AssetController::class, 'destroy'])->name('assets.destroy');