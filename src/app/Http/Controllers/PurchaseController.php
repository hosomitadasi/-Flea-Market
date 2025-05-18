<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// ログインユーザー情報などの認証情報を使用する欄。

use App\Http\Requests\AddressRequest;
// バリデーションであるAddressRequestを使用するためのコード

use App\Models\Item;
// 商品情報（itemsテーブル）を管理するモデル。

use App\Models\User;
// ユーザー情報（usersテーブル）を管理するモデル。

use App\Models\SoldItem;
// 購入済みの商品情報（sold_itemsテーブル）を扱うモデル。

use App\Models\Profile;
// ユーザーのプロフィール情報（Profileテーブル）を扱うモデル。

use Stripe\StripeClient;
// Stripeの支払い機能を提供する外部ライブラリ。

class PurchaseController extends Controller
{
    public function index($item_id, Request $request){
        // $item_idに基づいて購入対象となる商品情報を取得していく。

        $item = Item::find($item_id);
        // Itemsテーブルから今商品購入ページに入ってきたidと同じItem_idを探す。その情報を変数$itemに格納する。

        $user = USer::find(Auth::id());
        // ログイン中のユーザー情報をUsersテーブルから探し出し、変数$userに格納する。

        return view('purchase', compact('item', 'user'));
        // 探し出した結果をpurchase.blade.phpに表示させる。この時二つの変数（$item $user）を渡す。
    }
    // 商品購入ページを表示させます。

    public function purchase($item_id, Request $request){
        $item = Item::find($item_id);
        // 商品IDに対応する商品を取得する。

        $stripe = new StripeClient(config('stripe.stripe_secret_key'));
        // Stripeの秘密鍵を使って、支払い処理を行うためのクライアントを初期化。

        [
            $user_id,
            $amount,
            $sending_postcode,
            $sending_address,
            $sending_building
        ] = [
            Auth::id(),
            $item->price,
            $request->destination_postcode,
            //ASCIIコードに日本語はないため、住所と建物名はエンコードする必要あり
            urlencode($request->destination_address),
            urlencode($request->destination_building) ?? null
        ];
        // 支払いに必要な情報をまとめて取得し、エンコードして変数に格納。
        // Stripeが英数字しか扱えないため、住所など日本語部分はurlencodeで変換

        $checkout_session = $stripe->checkout->sessions->create([
            'payment_method_types' => [$request->payment_method],
            'payment_method_options' => [
                'konbini' => [
                    'expires_after_days' => 7,
                ],
            ],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => ['name' => $item->name],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => "http://localhost/purchase/{$item_id}/success?user_id={$user_id}&amount={$amount}&sending_postcode={$sending_postcode}&sending_address={$sending_address}&sending_building={$sending_building}",
        ]);

        return redirect($checkout_session->url);
        // ユーザーをStripeの決済ページへ遷移させる。
    }

    public function success($item_id, Request $request)
    {
        // 無事決済が成功した後に動くメソッドのため、決済以外でHTTPリクエストが送られた時用にクエリパラメータを検閲
        if(!$request->user_id || !$request->amount || !$request->sending_postcode || !$request->sending_address){
            throw new Exception("You need all Query Parameters (user_id, amount, sending_postcode, sending_address)");
        }

        $stripe = new StripeClient(config('stripe.stripe_secret_key'));

        $stripe->charges->create([
            'amount' => $request->amount,
            'currency' => 'jpy',
            'source' => 'tok_visa',
        ]);

        SoldItem::create([
            'user_id' => $request->user_id,
            'item_id' => $item_id,
            'sending_postcode' => $request->sending_postcode,
            'sending_address' => $request->sending_address,
            'sending_building' => $request->sending_building ?? null,
        ]);

        return redirect('/')->with('flashSuccess', '決済が完了しました！');
        // 購入が完了したら商品一覧ページへ遷移させ、「決済が完了しました！」の文字を表示させる。
    }

    public function address($item_id, Request $request){
        $user = User::find(Auth::id());
        // ログイン中のユーザー情報を取得する。

        return view('address', compact('user', 'item_id'));
        // 送付先住所変更用の画面（address.blade.php）にユーザー情報と商品IDを渡す。
    }

    public function updateAddress(AddressRequest $request){
        $user = User::find(Auth::id());
        // ログイン中のユーザーを取得。

        Profile::where('user_id', $user->id)->update([
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building
        ]);
        // profilesテーブル内のログインユーザーの住所情報を更新。
        // AddressRequestで事前にバリデーションされたリクエストデータを使用。

        return redirect()->route('purchase.index', ['item_id' => $request->item_id]);
        // 再度、購入確認ページに戻るようにリダイレクト。
    }
}
