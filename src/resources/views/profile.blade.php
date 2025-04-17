@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('main')
<div class="profile-container">
    <h2>プロフィール設定</h2>
    <form class="profile-card" action="" method="">
        @csrf
        <div class="profile-card_select">
            <img class="profile-card_icon" src="img/circle-user.png" alt="icon">
            <a class="profile-card_btn">画像を選択する</a>
        </div>

        <div class="profile-card__item">
            <p>ユーザー名</p>
            <input class="profile-card__item__input" />
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-card__item">
            <p>郵便番号</p>
            <input class="profile-card__item__input" />
            @error('zip-code')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-card__item">
            <p>住所</p>
            <input class="profile-card__item__input" />
            @error('address')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-card__item">
            <p>建物名</p>
            <input class="profile-card__item__input" />
            @error('building')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-card__btn">
            <input type="" value="更新する" />
        </div>
    </form>

</div>
@endsection