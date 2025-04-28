<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/search', [ProductController::class, 'index'])->name('products.search');
Route::get('/item/{item_id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth','profile')->group(function () {
     Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
     Route::post('/order', [OrderController::class, 'create'])->name('order.create');
     Route::post('/comment/store/{product_id}', [CommentController::class, 'store'])->name('comment.store');
 });