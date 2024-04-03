<?php

use App\Http\Controllers\api\ClientController;
use App\Http\Controllers\api\SupplyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('supply')->middleware(['cors'])->group(function () {
    Route::get('/all', [SupplyController::class, 'index'])->name('api.supply.index');
    Route::post('/find', [SupplyController::class, 'find'])->name('api.supply.find');
    Route::delete('/delete', [SupplyController::class, 'delete'])->name('api.supply.delete');
    Route::post('/store', [SupplyController::class, 'store'])->name('api.supply.store');
    Route::post('/update', [SupplyController::class, 'update'])->name('api.supply.update');
});

Route::prefix('clientes')->middleware(['cors', 'auth'])->group( function () {
    Route::get('/all', [ClientController::class, 'index'])->name('client.index');
    Route::post('/find', [ClientController::class, 'find'])->name('client.find');
    Route::delete('/delete', [ClientController::class, 'delete'])->name('client.delete');
    Route::post('/store', [ClientController::class, 'store'])->name('client.store');
    Route::put('/update', [ClientController::class, 'update'])->name('client.update');
});