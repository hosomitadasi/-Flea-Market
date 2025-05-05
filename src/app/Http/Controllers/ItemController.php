<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use App\Models\CategoryItem;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        /* ユーザーからURLにアクセスしたリクエスト（GET）を受け取り、リクエストオブジェクト（$request）を使って処理を開始する。 */

        $tab = $request->query('tab', 'recommend');
        /* クエリパラメータtabの値を取得する。指定されていない場合はrecommendをデフォルトとして設定する。 */

        $search = $request->query('search');
        /* クエリパラメータsearchを取得する（部分一致検索のキーワードとして使用する）。 */

        $query = Item::query();
        /* Eloquent の Item モデルをもとに、クエリビルダを初期化する。 */

        $query->where('user_id', '<>', Auth::id());
        /* 今ログインしているユーザーが出品した商品は除外する。 */

        if ($tab === 'mylist') {
            $query->whereIn('id', function ($query) {
                $query->select('item_id')->from('likes')->where('user_id', auth()->id());
            });
        }
        /* index.blade.phpにてmylistが指定されている場合は、「likesテーブルに存在する商品のみ表示するよう絞り込む」 */

        if($search){
            $query->where('name', 'like', "%{$search}%");
        }
        /* searchが入力されていた場合は、商品名(name)に部分一致する商品だけ抽出する。 */

        $items = $query->get();
        /* 上記条件をもとに、最終的な商品一覧を取得する。 */

        return view('index', compact('items', 'tab', 'search'));
        /* index.blade.phpにitems（商品データ）、tab（表示中のタブ）、search（検索語）を渡して描画する。 */
    }
    /*商品一覧画面（index.blade.php）を表示*/

    public function detail(Item $item)
    {
        return view('detail', compact('item'));
    }

    public function search(Request $request)
    {
        $search_word = $request->search_item;
        $query = Item::query();
        /* query=検索ということなので、ここで$queryにCreateItemsTableに格納されているデータを検索するということを格納している。 */
        $query = Item::scopeItem($query, $search_word);

        $items = $query->get();
        return view('index', compact("items"));
    }

    public function sellView()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell', compact('categories', 'conditions'));
    }

    public function sellCreate(ItemRequest $request)
    {
        $img = $request->file('img_url');

        try {
            $img_url = Storage::disk('local')->put('public/imag', $img);
        } catch (\Throwable $th) {
            throw $th;
        }

        $item = Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'brand' => $request->brand,
            'description' => $request->description,
            'image_url' => $img_url,
            'condition_id' => $request->condition_id,
            'user_id' => Auth::id(),
        ]);

        CategoryItem::create([
            'item_id' => $item->id,
            'category_id' => $request->category_id,
        ]);

        foreach ($request->categories as $category_id){
            CategoryItem::created([
                'item_id' => $item->id,
                'category_id' => $category_id
            ]);
        }

        return redirect()->route('item.detail',['item' => $item->id]);
    }
}
