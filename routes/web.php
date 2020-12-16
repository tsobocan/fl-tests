<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/get-rates', [\App\Http\Controllers\HomeController::class, 'fetchRatesFromApi'])->name('fetch');
Route::get('/report', [\App\Http\Controllers\HomeController::class, 'report'])->name('report');
Route::get('/export', [\App\Http\Controllers\HomeController::class, 'export'])->name('export');
