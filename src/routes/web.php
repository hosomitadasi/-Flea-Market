<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisterdUserController;
use App\Http\Controllers\UserController;

Route::get('/', [ItemController::class, 'showIndexForm'])->name('index');
Route::get('/detail', [ItemController::class, 'showDetailForm'])->name('detail');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::get('/verify-email', [UserController::class, 'showVerifyEmailForm'])->name('verify-email');

Route::get('/mypage', [RegisterdUserController::class, 'showMypageForm'])->name('mypage');
Route::get('/profile', [RegisterdUserController::class, 'showProfileForm'])->name('profile');

Route::get('/sell', [PurchaseController::class, 'showSellForm'])->name('sell');
Route::get('/purchase', [PurchaseController::class, 'showPurchaseForm'])->name('purchase');
Route::get('/address', [PurchaseController::class, 'showAddress'])->name('address');

Route::get('/', function () {
    return view('welcome');
});
