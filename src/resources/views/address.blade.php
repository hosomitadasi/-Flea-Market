@extends('layouts.app')

@section('main')
<div class="address-container">
    <h2>住所の変更</h2>
    <form class="address-card" action="" method="">
        @csrf
        <div class="address-card__item">
            <p>郵便番号</p>
            <input class="address-card__item__input" />
            @error('zip-code')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="address-card__item">
            <p>住所</p>
            <input class="address-card__item__input" />
            @error('address')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="address-card__item">
            <p>建物名</p>
            <input class="address-card__item__input" />
            @error('building')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="address-card__btn">
            <input type="" value="更新する" />
        </div>
    </form>
</div>
@endsection