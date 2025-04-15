@extends('layouts.app')

@section('main')
<div class="item-image">
    <img>
</div>

<div class="item-detail">
    <h2>商品名</h2>
    <p class="brand-name">ブランド名</p>
    <p class="price">￥料金がここに記載</p>

    <div class="reaction-bar">
        <div class="likes">
            <span><img></span> 0
        </div>
        <div class="comment-count">
            <span><img></span> 0
        </div>
    </div>

    <a href="purchase" class="buy-btn">購入手続きへ</a>

    <div class="section">
        <h3>商品説明</h3>
        <p class="description">商品の紹介部分</p>
    </div>

    <div class="section">
        <h3>商品の情報</h3>
        <p><strong>カテゴリー：</strong>
            <span class="tag">ここにタグが入る</span>
        </p>
        <p><strong>商品の状態：</strong>ここに商品の状態が入る</p>
    </div>

    <div class="section">
        <h3>コメント (0)</h3>
        <div class="comment-box">
            <img class="comment-icon" alt="アイコン">
            <div>
                <p class="comment-user">コメントしたユーザー名</p>
                <p class="comment-body">コメントされた内容</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>商品へのコメント</h3>
        <form method="" action="">
            @csrf
            <textarea name="body" rows="4" placeholder="コメントを入力してください..."></textarea>
            <button type="" class="comment-submit">コメントを送信する</button>
        </form>
    </div>

</div>
@endsection