@extends('layouts.app')

@section('main')
<form class="auth-card" action="" method="">
    @csrf
    <div class="auth-card__ttl">会員登録</div>
    <div class="auth-card__item">
        <p>ユーザー名</p>
        <input class="auth-card__item__input" />
        @error('name')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="auth-card__item">
        <p>メールアドレス</p>
        <input class="auth-card__item__input" />
        @error('email')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="auth-card__item">
        <p>パスワード</p>
        <input class="auth-card__item__input" />
        @error('password')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="auth-card__item">
        <p>確認用パスワード</p>
        <input class="auth-card__item__input" />
        @error('password')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="auth-card__btn">
        <input type="" value="登録する" />
    </div>
</form>
@endsection