@extends('layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('css/authentication.css') }}">
@endsection

@section('content')
<form class="auth-card" action="" method="">
    @csrf
    <div class="auth-card__ttl">ログイン</div>
    <div class="auth-card__item">
        <p>メールアドレス</p>
        <input class="auth-card__item__input" />
        @error('email')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class=" auth-card__item">
<p>パスワード</p>
<input class="auth-card__item__input" />
@error('password')
<p class="error">{{ $message }}</p>
@enderror
</div>
<div class="auth-card__btn">
    <input type="" value="ログインする" />
</div>
</form>
@endsection