<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// ログイン認証に関連する機能を使用するためのコード。今回の場合ログイン後のアクションなどを指定するために利用する。
use App\Http\Requests\ItemRequest;
// Requests内のItemRequestに接続する。
use App\Models\Item;
// Models内のItem.phpに接続する。
use App\Models\Category;
// Models内のCategory.phpに接続する。
use App\Models\Condition;
// Models内のCondition.phpに接続する。
use App\Models\CategoryItem;
// Models内のCategoryItem.phpに接続する。

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // ユーザーからURLにアクセスしたリクエスト（GET）を受け取り、リクエストオブジェクト（$request）を使って処理を開始する。

        $tab = $request->query('tab', 'recommend');
        // クエリパラメータtabの値を取得する。指定されていない場合はrecommendをデフォルトとして設定する。

        $search = $request->query('search');
        // クエリパラメータsearchを取得する（部分一致検索のキーワードとして使用する）。

        $query = Item::query();
        // Eloquent の Item モデルをもとに、クエリビルダを初期化する。

        $query->where('user_id', '<>', Auth::id());
        // 今ログインしているユーザーが出品した商品は除外する。

        if ($tab === 'mylist') {
            $query->whereIn('id', function ($query) {
                $query->select('item_id')->from('likes')->where('user_id', auth()->id());
            });
        }
        // index.blade.phpにてmylistが指定されている場合は、「likesテーブルに存在する商品のみ表示するよう絞り込む。

        if($search){
            $query->where('name', 'like', "%{$search}%");
        }
        // searchが入力されていた場合は、商品名(name)に部分一致する商品だけ抽出する。

        $items = $query->get();
        // 上記条件をもとに、最終的な商品一覧を取得する。

        return view('index', compact('items', 'tab', 'search'));
        // index.blade.phpにitems（商品データ）、tab（表示中のタブ）、search（検索語）を渡して描画する。
    }
    /*商品一覧画面（index.blade.php）を表示*/

    public function detail(Item $item)
    {
        return view('detail', compact('item'));
    }

    public function search(Request $request)
    {
        // header.blade.phpの/searchのアクセスを受けたら発動する。

        $search_word = $request->search_item;
        // リクエストからsearch_itemというパラメータ（検索キーワード）を取得して変数$search_wordに入れる。

        $query = Item::query();
        // Itemモデルからクエリビルダを初期化する。

        $query = Item::scopeItem($query, $search_word);
        // ItemモデルにscopeItemが定義されていて、検索キーワードを使った絞り込みを行う。

        $items = $query->get();
        // 上記条件をもとに、最終的に検索で一致した商品を一覧として取得する。
        return view('index', compact("items"));
        // index.blade.phpに変数itemsを渡して表示する。
    }

    public function sellView()
    {
        $categories = Category::all();
        // Categoryモデルの全ての項目を変数$categoriesに格納する。

        $conditions = Condition::all();
        // Conditionモデルの全ての項目を変数$conditionsに格納する。

        return view('sell', compact('categories', 'conditions'));
        // sellViewに変数categoriesとconditionを渡しつつ表示する。
    }

    public function sellCreate(ItemRequest $request)
    {
        // sell.blade.phpでの出品リクエストを受け取って実行されるアクション。入力チェックは事前に作成してあるItemRequestを参照して行う。勿論内容が違反していた場合はエラー文を表示させるように処理させる。

        $img = $request->file('img_url');
        // 送信された画像ファイルを取得する。name属性がimg_urlの<input type="file">に対応している。変数の$imgに一時格納されることになる。

        try {
            $img_url = Storage::disk('local')->put('public/imag', $img);
        } catch (\Throwable $th) {
            throw $th;
        }
        // Storage::disk('local') は storage/app/ に保存するという指定。その後put('public/imag', $img) により storage/app/public/imag フォルダにファイルを保存することになる。変数$img_urlには保存されたパスが返される。try-catchは、アップロードする際にエラーが起きたら原因をlaravelのエラーページで確認できるようにするため。

        $item = Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'brand' => $request->brand,
            'description' => $request->description,
            'image_url' => $img_url,
            'condition_id' => $request->condition_id,
            'user_id' => Auth::id(),
        ]);
        // 出品された商品情報を items テーブルに登録する。request->○○が保存する各項目、Auth::id()はログイン中のユーザーIDを取得し、出品者と商品を紐づけする役割を持つ。変数$itemには作成されたItemモデルのインスタンスが格納される。

        CategoryItem::create([
            'item_id' => $item->id,
            'category_id' => $request->category_id,
        ]);
        // カテゴリーだけ中間テーブルのCategory_itemに保存する。1つの商品に複数のカテゴリーを当てはめるにあたり商品とカテゴリーの多対多関係を結びつけるため。まだここではcategory_idは1つのみとして処理。

        foreach ($request->categories as $category_id){
            CategoryItem::create([
                'item_id' => $item->id,
                'category_id' => $category_id
            ]);
        }
        // 配列として送られてくる categories[] をループで回し、それぞれを category_item に登録する。

        return redirect()->route('item.detail',['item' => $item->id]);
        // 商品IDを渡して商品詳細ページへと遷移させる。
    }
}
