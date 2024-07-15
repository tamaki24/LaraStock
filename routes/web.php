<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemMasterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::redirect('/dashboard', 'home')->name('dashboard');


Route::middleware('auth')->group(function () {
    /***************************************************
     * PageRoute
     ***************************************************/
    Route::get('/home', [StockController::class, 'home'])->name('home');

    Route::get('/stock', [StockController::class, 'index'])->name('stock');
    Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
    Route::get('/stock/{stock_id}', [StockController::class, 'edit'])->name('stock.edit');

    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::get('/category/{category_id}', [CategoryController::class, 'edit'])->name('category.edit');

    Route::get('/item', [ItemMasterController::class, 'index'])->name('item');
    Route::get('/item/create', [ItemMasterController::class, 'create'])->name('item.create');
    Route::get('/item/{stock_id}', [ItemMasterController::class, 'edit'])->name('item.edit');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /***************************************************
     * APIRoute
     ***************************************************/
    Route::get('/api/stock', [StockController::class, 'getStocks'])->name('api.stock.get');
    Route::patch('/api/stock', [StockController::class, 'editStock'])->name('api.stock.patch');
    Route::post('/api/stock', [StockController::class, 'createStock'])->name('api.stock.post');
    Route::delete('/api/stock', [StockController::class, 'deleteStock'])->name('api.stock.delete');

    Route::get('/api/category', [CategoryController::class, 'getCategory'])->name('api.category.get');
    Route::patch('/api/category', [CategoryController::class, 'editCategory'])->name('api.category.patch');
    Route::post('/api/category', [CategoryController::class, 'createCategory'])->name('api.category.post');
    Route::delete('/api/category', [CategoryController::class, 'deleteCategory'])->name('api.category.delete');

    Route::get('/api/item', [ItemMasterController::class, 'getItem'])->name('api.item.get');
    Route::patch('/api/item', [ItemMasterController::class, 'editItem'])->name('api.item.patch');
    Route::post('/api/item', [ItemMasterController::class, 'createItem'])->name('api.item.post');
    Route::delete('/api/item', [ItemMasterController::class, 'deleteItem'])->name('api.item.delete');
});



require __DIR__ . '/auth.php';
