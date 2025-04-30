@extends('layouts.default')

@section('title','トップページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@include('components.header')
<div class="border">
    <ul class="border__list">
        <li><a href="{{ route('items.list', ['tab'=>'recommend', 'search'=>$search]) }}">おすすめ</a></li>
        @if(!auth()->guest())
        <li><a href="{{ route('items.list', ['tab'=>'mylist', 'search'=>$search]) }}">マイリスト</a></li>
        @endif
    </ul>
    <!-- ここのif分はもし認証していなかったらゲスト判定＝押した場合何も表示されない画面を表示するようにという指示を出している。 -->
</div>
<div class="container">
    <div class="items">
        @foreach ($items as $item)
        <div class="item">
            <a href="/item/{{$item->id}}">
                @if ($item->sold())
                <div class="item__img--container sold">
                    <img src="{{ \Storage::url($item->img_url) }}" class="item__img" alt="商品画像">
                </div>
                @else
                <div class="item__item--container">
                    <img src="{{ \Storage::url($item->img_url) }}" class="item__img" alt="商品画像">
                </div>
                @endif
                <!-- ここはifでもし商品が販売されていれば購入済画像を表示する処理を行い、elseで販売がされていない場合は通常画像を表示する処理を行うことを表している。 -->
                <p class="item__name">{{$item->name}}</p>
                <!-- {{$item->name}}でCreateItemsTableにあるnameカラムを表示させる処理を行う。 -->
            </a>
        </div>
        @endforeach
        <!-- ここのforeachはcreateItemsTableの情報を取得することを表している。 -->
    </div>
</div>
@endsection