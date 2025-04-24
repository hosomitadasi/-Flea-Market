@extends('layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <div class="purchase-main">
        <div class="item-box">
            <img src="" alt="商品画像" class="item-image">
            <div class="item-info">
                <h2 class="item-name">商品名</h2>
                <p class="item-price">¥料金</p>
            </div>
        </div>

        <form action="" method="">
            @csrf

            <div class="section">
                <label for="payment">支払い方法</label>
                <select name="payment_method" id="payment" required>
                    <option value="">選択してください</option>
                    <option value="convenience">コンビニ払い</option>
                    <option value="credit_card">クレジットカード</option>
                    <option value="bank_transfer">銀行振込</option>
                </select>
            </div>

            <div class="section address-section">
                <label>配送先</label>
                <div class="address-box">
                    <p>〒 郵便番号がここに入る</p>
                    <p>住所、建物名をここに記載</p>
                </div>
                <a href="address" class="change-address">変更する</a>
            </div>

            <div class="purchase-summary-box">
                <table>
                    <tr>
                        <th>商品代金</th>
                        <td>¥ 代金をそのまま記載</td>
                    </tr>
                    <tr>
                        <th>支払い方法</th>
                        <td id="selected-payment">コンビニ払い</td> {{-- JSで動的変更可能 --}}
                    </tr>
                </table>
                <button type="" class="purchase-button">購入する</button>
            </div>
        </form>
    </div>
</div>
@endsection