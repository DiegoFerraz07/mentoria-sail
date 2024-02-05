<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\TypesController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
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

Route::prefix('clientes')->group( function () {
    Route::get('/', [ClientController::class, 'index'])->name('client.index');
    Route::get('/find', [ClientController::class, 'index']);
    Route::post('/find', [ClientController::class, 'find'])->name('client.find');
    Route::delete('/delete', [ClientController::class, 'delete'])->name('client.delete');
    Route::get('/add', [ClientController::class, 'add'])->name('client.add');
    Route::post('/store', [ClientController::class, 'store'])->name('client.store');
});

Route::prefix('types')->group( function () {
    Route::get('/', [TypesController::class, 'index'])->name('types.index');
    Route::get('/find', [TypesController::class, 'index']);
    Route::post('/find', [TypesController::class, 'find'])->name('types.find');
    Route::get('/edit/{id}', [TypesController::class, 'edit'])->name('types.edit');
    Route::delete('/delete', [TypesController::class, 'delete'])->name('types.delete');
    Route::get('/add', [TypesController::class, 'add'])->name('types.add');
    Route::post('/store', [TypesController::class, 'store'])->name('types.store');
    Route::post('/update', [TypesController::class, 'update'])->name('types.update');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Auth::routes();


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::patch('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

