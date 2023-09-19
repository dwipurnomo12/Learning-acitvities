<?php

use App\Models\Metode;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BulanController;
use App\Http\Controllers\MetodeController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [DashboardController::class, 'index']);
Route::resource('/dashboard', DashboardController::class);

Route::get('/metode/get-data', [MetodeController::class, 'getDataMetode']);
Route::resource('/metode', MetodeController::class);

Route::get('/bulan/get-data', [BulanController::class, 'getDataBulan']);
Route::resource('/bulan', BulanController::class);

Route::get('/activity/get-data', [ActivityController::class, 'getDataActivity']);
Route::resource('/activity', ActivityController::class);
