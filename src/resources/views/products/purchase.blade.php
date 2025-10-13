@extends('layouts.app')

@section('title', '商品購入手画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="checkout-grid">
    <!-- 左側：商品情報・支払い方法・配送先 -->
    <div class="checkout-left">
        <section class="product-summary">
            <div class="product-info-box">
                <img src="{{ asset('storage/products/watch.jpg') }}" alt="商品画像" class="product-image">

                <div class="product-text">
                    <p class="product-name">商品名（仮）</p>
                    <p class="product-price"><span class="yen">¥</span>47,000</p>
                </div>
            </div>
        </section>


        <section class="payment-method">
            <h2 class="payment-title">支払い方法</h2>
            <select name="payment" class="payment-select">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ払い</option>
                <option value="credit">クレジットカード</option>
                <option value="bank">銀行振込</option>
            </select>
        </section>

        <section class="delivery-info">
            <div class="delivery-header">
                <h2 class="delivery-title">配送先</h2>
                {{-- <a href="{{ route('address') }}" class="change-link">変更する</a> --}}
                {{-- 実装前なので仮リンクにしておく --}}
                <a href="#" class="change-link">変更する</a>

            </div>

            {{-- <p class="delivery-address">
                {{ $user->postal_code }}<br>
            {{ $user->address }}
            </p> --}}

            <p>〒XXX-YYYY</p>
            <p>ここに住所などが入ります</p>
        </section>
    </div>

    <section class="order-summary">
        <div class="summary-box">
            <div class="summary-row">
                <span class="summary-label">商品代金</span>
                <span class="summary-value"><span class="yen">¥</span>{{ $item->price ?? '47,000' }}</span>
            </div>

            <div class="summary-divider"></div> <!-- ← 罫線ここ！ -->

            <div class="summary-row">
                <span class="summary-label">支払い方法</span>
                <span class="summary-value">{{ $paymentMethod ?? 'コンビニ払い' }}</span>
            </div>
        </div>


        <button class="purchase-button">購入する</button>
    </section>

</div>
@endsection