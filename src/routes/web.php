<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Requests\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', [ItemController::class, 'index'])->name('items.list');
// ItemControllerのindexアクション（商品一覧画面表示処理）を呼び出し、商品一覧画面を表示。index(Request $request)内でタブ切り替えや検索パラメータを受け取り、該当する商品の一覧を返す。

Route::get('/item/{item}', [ItemController::class, 'detail'])->name('item.detail');
// ItemControllerのdetailアクション（商品詳細画面表示処理）を呼び出し、商品詳細画面を表示。$itemの情報を入れてdetail.blade.phpを返す。検索ということでGETリクエスト（データの取得）を使用。大量のデータがある場合や、機密情報がある場合はPOSTリクエストの場合もあり。

Route::get('/item', [ItemController::class, 'search']);
// ItemControllerのsearchアクション（検索処理）を呼び出し、キーワード検索結果を表示させる。$request->search_item を受け取り、スコープメソッドで絞り込んだ一覧を返す。

Route::middleware(['auth', 'verified'])->group(function () {
    // これより以下のルートは全てログイン済みかつメール認証済みのユーザーだけアクセス可能となる。（auth = ログイン済 verified = メール認証済）

    Route::get('/sell', [ItemController::class, 'sellView']);
    // ItemControllerのsellView（出品画面表示処理）アクションを呼び出し、sell.blade.phpにカテゴリ・及び状態のリストを渡して出品フォームを表示させる。

    Route::post('/sell', [ItemController::class, 'sellCreate']);
    // ItemControllerのsellCreateアクション（商品出品処理）を呼び出し、出品フォームで入力された情報と画像を受け取り、画像のアップロード・items・category_itemテーブルに保存。詳細ページへ遷移させる。

    Route::post('/item/like/{item_id}', [LikeController::class, 'create']);
    // LikeControllerのcreateアクション（いいね追加処理）を呼び出し、LikeDBを操作し情報を登録する。

    Route::post('/item/unlike/{item_id}', [LikeController::class, 'destroy']);
    // LikeControllerのdestroyアクション（いいね削除処理）を呼び出し、LikeDBを操作し情報を削除する。

    Route::post('/item/comment/{item_id}', [CommentController::class, 'create']);
    // CommentControllerのcreateアクション（コメント追加処理）を呼び出し、フォームに入力された情報をCommentDBに保存する。

    Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])->middleware('purchase')->name('purchase.index');
    /* PurchaseControllerのindexアクション（購入画面表示処理）を引き出すルート ミドルウェア処理*/

    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->middleware('purchase');
    // PurchaseControllerのpurchaseアクション（購入処理）を呼び出し、購入フォームに商品とユーザー情報を埋め込む。

    Route::get('/purchase/{item_id}/success', [PurchaseController::class, 'success']);
    // PurchaseControllerのsuccessアクション（支払い完了のコールバック）を呼び出す。

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
// Fortifyのstore()が認証処理を行い、ログインに失敗した場合は再表示、成功したらintended咲へ

Route::post('/register', [RegisteredUserController::class, 'store']);
/* RegisteredUserControllerのstoreアクション（会員登録処理）を呼び出しユーザー作成、その後Registeredイベントを起こし未認証ユーザーをセッションに保存して認証案内画面へ遷移させる。 */

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');
/* メール認証画面の表示を引き出すルート */

Route::post('/email/verification-notification', function (Request $request) {
    session()->get('unauthenticated_user')->sendEmailVerificationNotification();
    session()->put('resent', true);
    return back()->with('message', 'Verification link sent!');
})->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    session()->forget('unauthenticated_user');
    return redirect('/mypage/profile');
})->name('verification.verify');