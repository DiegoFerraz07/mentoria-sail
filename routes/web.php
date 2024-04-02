<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

Route::prefix('produtos')->middleware(['cors', 'auth'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/find', [ProductController::class, 'index']);
    Route::post('/find', [ProductController::class, 'find'])->name('product.find');
    Route::delete('/delete', [ProductController::class, 'delete'])->name('product.delete');
    Route::get('/add', [ProductController::class, 'add'])->name('product.add');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/update', [ProductController::class, 'update'])->name('product.update');
});

Route::prefix('fornecedores')->middleware(['cors', 'auth'])->group(function() {
    Route::get('/', [SupplyController::class, 'index'])->name('supply.index');
    Route::get('/add', [SupplyController::class, 'add'])->name('supply.add');
    Route::post('/store', [SupplyController::class, 'store'])->name('supply.store');
    Route::get('/edit/{id}', [SupplyController::class, 'edit'])->name('supply.edit');
    Route::post('/update', [SupplyController::class, 'update'])->name('supply.update');
});

Route::prefix('clientes')->middleware(['cors', 'auth'])->group( function () {
    Route::get('/', [ClientController::class, 'index'])->name('client.index');
    Route::get('/find', [ClientController::class, 'index']);
    Route::post('/find', [ClientController::class, 'find'])->name('client.find');
    Route::delete('/delete', [ClientController::class, 'delete'])->name('client.delete');
    Route::get('/add', [ClientController::class, 'add'])->name('client.add');
    Route::post('/store', [ClientController::class, 'store'])->name('client.store');
    Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('/update', [ClientController::class, 'update'])->name('client.update');
});

Route::prefix('types')->middleware(['cors', 'auth'])->group( function () {
    Route::get('/', [TypesController::class, 'index'])->name('types.index');
    Route::get('/find', [TypesController::class, 'index']);
    Route::post('/find', [TypesController::class, 'find'])->name('types.find');
    Route::get('/edit/{id}', [TypesController::class, 'edit'])->name('types.edit');
    Route::delete('/delete', [TypesController::class, 'delete'])->name('types.delete');
    Route::get('/add', [TypesController::class, 'add'])->name('types.add');
    Route::post('/store', [TypesController::class, 'store'])->name('types.store');
    Route::post('/update', [TypesController::class, 'update'])->name('types.update');
});

Route::prefix('brand')->middleware(['cors', 'auth'])->group( function () {
    Route::get('/', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/find', [BrandController::class, 'index']);
    Route::post('/find', [BrandController::class, 'find'])->name('brand.find');
    Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::delete('/delete', [BrandController::class, 'delete'])->name('brand.delete');
    Route::get('/add', [BrandController::class, 'add'])->name('brand.add');
    Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
    Route::post('/update', [BrandController::class, 'update'])->name('brand.update');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::patch('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

