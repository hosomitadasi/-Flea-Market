<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ItemController extends Controller
{
    public function index()
    {
        $items = Item::getItems();
        /*CreateItemsTableからそれぞれのitemカラムの情報を抽出。index.blade.phpにてそれぞれ表示する。*/
        return view('index', compact("items"));
        /*index.blade.phpへ返す*/
    }
    /*商品一覧画面（index.blade.php）を表示*/

    public function detail($item_id)
    {
        $item = Item::with('name', 'price', 'user', 'brand', 'description', 'img_url', 'user_', 'likes')->findOrFail($item_id);
        $likesCount = $item->likes->count();
        $commentsCount = $item->comments->count();
        $today = Carbon::now()->toDateString();

        return view('detail', compact("item", "likesCount", "commentsCount", "today"));
    }

    public function search(Request $request)
    {
        $keyword = $request['keyword'];
        $searchResult = Item::searchItems($keyword);
        $items = $searchResult['items'];

        return view('index', compact("items"));
    }

    public function sellView()
    {}

    public function sellCreate()
    {}
}
