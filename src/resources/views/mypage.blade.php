@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('main')
<div class="mypage-container">
    <div class="profile-header">
        <div class="user-info">
            <img class="user-icon" src="img/circle-user.png" alt="icon" >
            <h2>ユーザー名</h2>
        </div>
        <a href="/profile" class="edit-profile-btn">プロフィールを編集</a>
    </div>

    <div class="tab-menu">
        <a href="?page=sell" class="tab active">出品した商品</a>
        <a href="?page=buy" class="tab">購入した商品</a>
    </div>

    <div class="item-grid">
        <div class="item-card">
            <img alt="商品画像" class="item-image">
            <p class="item-name">ここに商品名が入る</p>
        </div>
    </div>
</div>
@endsection