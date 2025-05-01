<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FavoriteController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/search', [ProductController::class, 'index'])->name('products.search');
Route::get('/item/{product_id}', [ProductController::class, 'show'])->name('products.show');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest'])
    ->name('register');

Route::middleware('auth')->group(function () {
     Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
     Route::post('/order', [OrderController::class, 'create'])->name('order.create');
     Route::post('/comment/store/{product_id}', [CommentController::class, 'store'])->name('comment.store');
     Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    
    Route::get('/address/edit/{product}', [AddressController::class, 'edit'])->name('address.edit');

    Route::get('/purchase/address/{product_id}', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');
    Route::post('/purchase/address/{product_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');

    Route::get('/purchase/complete/{product}', [PurchaseController::class, 'complete'])->name('purchase.complete');
 });

    Route::get('/purchase/{product}', [PurchaseController::class, 'show'])
    ->middleware('auth')
    ->name('purchase.show');

    Route::post('/purchase/pay', [PurchaseController::class, 'pay'])
    ->middleware('auth')
    ->name('purchase.pay');

    Route::post('/favorite/{product}', [FavoriteController::class, 'toggle'])->middleware('auth')->name('favorite.toggle');