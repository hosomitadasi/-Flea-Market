@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('main')
<div class="verify-container">
    <div class="verify-container_word">
        <p>登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。</p>
    </div>
    <button class="verify-container_button">認証はこちらから</button>
    <a>認証メールを再送する</a>
</div>
@endsection