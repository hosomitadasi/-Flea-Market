@extends('layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-container">
    <h2>商品の出品</h2>
    <form class="sell-card">
        <div class="sell-card__item">
            <p>商品画像</p>
            @error('img')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-card__ttl">
            <p>商品の詳細</p>
        </div>
        <div class="sell-card__border"></div>

        <div class="sell-card__item">
            <p>カテゴリー</p>
            @error('condition')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-card__item">
            <p>商品の状態</p>
            <p>プルダウンをここに</p>
            @error('condition')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-card__ttl">
            <p>商品名と説明</p>
        </div>
        <div class="sell-card__border"></div>

        <div class="sell-card__item">
            <p>商品名</p>
            <input class="sell-card__item__input" />
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-card__item">
            <p>ブランド名</p>
            <input class="sell-card__item__input" />
            @error('brand-name')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-card__item">
            <p>商品の説明</p>
            <input class="sell-card__item__input" />
            @error('')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-card__item">
            <p>販売価格</p>
            <input class="sell-card__item__input" value="￥" />
            @error('price')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="sekk-card__btn">
            <input type="" value="出品する" />
        </div>
    </form>
</div>
@endsection