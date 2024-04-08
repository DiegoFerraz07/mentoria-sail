<?php

use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\ClientController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\SupplyController;
use App\Http\Controllers\api\TypesController;
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

Route::prefix('produtos')->middleware(['cors'])->group(function () {
    Route::get('/all', [ProductController::class, 'index'])->name('api.product.index');
    Route::post('/find', [ProductController::class, 'find'])->name('api.product.find');
    Route::delete('/delete', [ProductController::class, 'delete'])->name('api.product.delete');
    Route::post('/store', [ProductController::class, 'store'])->name('api.product.store');
    Route::put('/update', [ProductController::class, 'update'])->name('api.product.update');
});

Route::prefix('supply')->middleware(['cors'])->group(function () {
    Route::get('/all', [SupplyController::class, 'index'])->name('api.supply.index');
    Route::post('/find', [SupplyController::class, 'find'])->name('api.supply.find');
    Route::delete('/delete', [SupplyController::class, 'delete'])->name('api.supply.delete');
    Route::post('/store', [SupplyController::class, 'store'])->name('api.supply.store');
    Route::post('/update', [SupplyController::class, 'update'])->name('api.supply.update');
});

Route::prefix('clientes')->middleware(['cors'])->group( function () {
    Route::get('/all', [ClientController::class, 'index'])->name('api.client.index');
    Route::post('/find', [ClientController::class, 'find'])->name('api.client.find');
    Route::delete('/delete', [ClientController::class, 'delete'])->name('api.client.delete');
    Route::post('/store', [ClientController::class, 'store'])->name('api.client.store');
    Route::put('/update', [ClientController::class, 'update'])->name('api.client.update');
});

Route::prefix('brand')->middleware(['cors'])->group( function () {
    Route::get('/all', [BrandController::class, 'index'])->name('api.brand.index');
    Route::post('/find', [BrandController::class, 'find'])->name('api.brand.find');
    Route::delete('/delete', [BrandController::class, 'delete'])->name('api.brand.delete');
    Route::post('/store', [BrandController::class, 'store'])->name('api.brand.store');
    Route::post('/update', [BrandController::class, 'update'])->name('api.brand.update');
});

Route::prefix('types')->middleware(['cors'])->group( function () {
    Route::get('/', [TypesController::class, 'index'])->name('api.types.index');
    Route::post('/find', [TypesController::class, 'find'])->name('api.types.find');
    Route::delete('/delete', [TypesController::class, 'delete'])->name('api.types.delete');
    Route::post('/store', [TypesController::class, 'store'])->name('api.types.store');
    Route::post('/update', [TypesController::class, 'update'])->name('api.types.update');
});