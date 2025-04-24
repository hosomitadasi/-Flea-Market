@extends('layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@include('components.header')

<div class="toppage-list">
    <div class="toppage-list_item">
        <p>おすすめ</p>
    </div>
    <div class="toppage-list_item">
        <p>マイリスト</p>
    </div>
    <div class="toppage-list_border"></div>
</div>
<div class="product-list">
    <div class="product-list_card">
        <div class="product-list_img"></div>
        <div class="product-list_name">商品名</div>
    </div>
</div>
@endsection