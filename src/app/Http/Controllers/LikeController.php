<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
// Models内のLike.phpに接続させる。
use Illuminate\Support\Facades\Auth;
// ログイン済みかの確認やユーザー情報の取得を行うことができる。

class LikeController extends Controller
{
    public function create($item_id, Request $request)
    {
        // detail.blade.phpの中で該当するitem_idをCreateLikeTableに追加するためのアクション。$item_idは追加ボタンを押したitem_idで処理を行うということを表す。

        Like::create([
            'user_id' => Auth::id(),
            'item_id' => $item_id
        ]);
        // CreateLikeTableに新たに追加するための処理。”誰が” ”どの商品を” 追加したかを確認するためにuser_idとitem_idを合わせて追加する。

        return back();;
        // 追加した結果をそのまま元のitem_idのdetail.blade.phpに反映させる。
    }

    public function destroy($item_id, Request $request)
    {
        // detail.blade.phpでCreateLikeTableに追加した情報を削除するためのアクション。$item_idはトリガーとなるボタンを押したitem_idのlike_idを削除するという処理を行うということを表す。
        Like::where(['user_id' => Auth::id(), 'item_id' => $item_id])->delete();
        return back();
    }
}
