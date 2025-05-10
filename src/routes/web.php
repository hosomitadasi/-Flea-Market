<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', [ItemController::class, 'index'])->name('items.list');
/* ItemControllerのindexアクション（商品一覧画面表示処理）を引き出すルート */

Route::get('/item/{item}', [ItemController::class, 'detail'])->name('item.detail');
/* ItemControllerのdetailアクション（商品詳細画面表示処理）を引き出すルート */

Route::get('/item', [ItemController::class, 'search']);
/* ItemControllerのsearchアクション（検索処理）を引き出すルート */

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/sell', [ItemController::class, 'sellView']);
    /* ItemControllerのsellView（出品画面表示処理）アクションを引き出すルート */

    Route::post('/sell', [ItemController::class, 'sellCreate']);
    /* ItemControllerのsellCreateアクション（商品出品処理）を引き出すルート */

    Route::post('/item/like/{item_id}', [LikeController::class, 'create']);
    /* LikeControllerのcreateアクション（いいね追加処理）を引き出すルート */

    Route::post('/item/unlike/{item_id}', [LikeController::class, 'destroy']);
    /* LikeControllerのdestroyアクション（いいね削除処理）を引き出すルート */

    Route::post('/item/comment/{item_id}', [CommentController::class, 'create']);
    /* CommentControllerのcreateアクション（コメント追加処理）を引き出すルート */

    Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])->middleware('purchase')->name('purchase.index');
    /* PurchaseControllerのindexアクション（購入画面表示処理）を引き出すルート ミドルウェア処理*/

    Route::post('purchase/{item_id}', [PurchaseController::class, 'purchase'])->middleware('purchase');
    /* PurchaseControllerのpurchaseアクション（購入処理）を引き出すルート ミドルウェア処理 */

    Route::get('purchase/{item_id}/success', [PurchaseController::class, 'success']);
    /* PurchaseControllerのsuccessアクション（）を引き出すルート */

    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address']);
    /* PurchaseControllerのaddressアクション（住所変更画面表示処理）を引き出すルート */

    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress']);
    /* PurchaseControllerのupdateAddressアクション（住所変更処理）を引き出すルート */

    Route::get('/mypage', [UserController::class, 'mypage']);
    /* UserControllerのmypageアクション（プロフィール画面表示処理）を引き出すルート */

    Route::get('/mypage/profile', [UserController::class, 'profile']);
    /* UserControllerのprofileアクション（プロフィール編集画面表示処理）を引き出すルート */

    Route::post('/mypage/profile', [UserController::class, 'updateProfile']);
    /* UserControllerのupdateProfileアクション（プロフィール編集処理）を引き出すルート */
});

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('email');
/* AuthenticatedSessionControllerのstoreアクション（ログイン処理）を引き出すルート。その後のmiddlewareにより */

Route::post('/register', [RegisteredUserController::class, 'store']);
/* RegisteredUserControllerのstoreアクション（会員登録処理）を引き出すルート */

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');
/* メール認証画面の表示を引き出すルート */
