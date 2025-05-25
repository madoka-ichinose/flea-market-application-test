<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\TabController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/tab', [TabController::class, 'show'])->name('tab.show');

Route::get('/search', [ProductController::class, 'index'])->name('products.search');
Route::get('/item/{product_id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth','verified')->group(function () {
     Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
     
     Route::post('/comment/store/{product_id}', [CommentController::class, 'store'])->name('comment.store');
     
     Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    
    Route::get('/address/edit/{product}', [AddressController::class, 'edit'])->name('address.edit');

    Route::get('/purchase/address/{product_id}', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');
    Route::post('/purchase/address/{product_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');

    Route::get('/purchase/complete/{product}', [PurchaseController::class, 'complete'])->name('purchase.complete');

    Route::get('/sell', [ProductController::class, 'create'])->name('products.create');
    Route::post('/sell', [ProductController::class, 'store'])->name('products.store');
 });

    Route::get('/purchase/{product}', [PurchaseController::class, 'show'])
    ->middleware('auth','verified')
    ->name('purchase.show');

    Route::post('/purchase/pay', [PurchaseController::class, 'pay'])
    ->middleware('auth','verified')
    ->name('purchase.pay');

    Route::post('/favorite/{product}', [FavoriteController::class, 'toggle'])->middleware('auth','verified')->name('favorite.toggle');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('message', '認証メールを再送信しました。');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    
    Route::get('/verify', function () {
        return view('auth.verify');
    })->middleware(['auth'])->name('verification.notice');
    
    Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/mypage/profile');
    })->middleware(['auth', 'signed'])->name('verification.verify');