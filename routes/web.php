<?php

use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\SupplyController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

Route::prefix('produtos')->group( function () {
    Route::get('/', [ProdutosController::class, 'index'])->name('produto.index');
    Route::delete('/delete', [ProdutosController::class, 'delete'])->name('produto.delete');
});

Route::prefix('fornecedores')->group(function() {
    Route::get('/', [SupplyController::class, 'index'])->name('supply.index');
    Route::get('/find', [SupplyController::class, 'index']);
    Route::post('/find', [SupplyController::class, 'find'])->name('supply.find');
    Route::delete('/delete', [SupplyController::class, 'delete'])->name('supply.delete');
    Route::get('/add', [SupplyController::class, 'add'])->name('supply.add');
    Route::post('/store', [SupplyController::class, 'store'])->name('supply.store');
    Route::get('/edit/{id}', [SupplyController::class, 'edit'])->name('supply.edit');
    Route::post('/update', [SupplyController::class, 'update'])->name('supply.update');
});
