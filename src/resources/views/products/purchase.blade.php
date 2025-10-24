@extends('layouts.app')

@section('title', '商品購入手続き')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="checkout-grid">
    <!-- 左側：商品情報・支払い方法・配送先 -->
    <div class="checkout-left">
        <section class="product-summary">
            <div class="product-info-box">
                <img src="{{ asset('storage/products/' . ($product->image_path ?? 'default.jpg')) }}" alt="商品画像" class="product-image">

                <div class="product-text">
                    <p class="product-name">{{ $product->name ?? '商品名未設定' }}</p>
                    <p class="product-price"><span class="yen">¥</span>{{ number_format($product->price ?? 0) }}</p>
                </div>
            </div>
        </section>

        <section class="payment-method">
            <h2 class="payment-title">支払い方法</h2>
            <select name="payment" class="payment-select">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ払い</option>
                <option value="credit">カード支払い</option>
            </select>
        </section>

        <section class="delivery-info">
            <div class="delivery-header">
                <h2 class="delivery-title">配送先</h2>
                <a href="{{ route('address_edit', ['item_id' => $product->id]) }}" class="change-link">変更する</a>
            </div>

            @if(isset($user))
            <p class="delivery-address">
                〒{{ $user->postal_code ?? '未登録' }}<br>
                {{ $user->address ?? '住所未登録' }}
            </p>
            @else
            <p>〒XXX-YYYY</p>
            <p>ここに住所などが入ります</p>
            @endif
        </section>
    </div>

    <!-- 右側：注文概要と購入ボタン -->
    <section class="order-summary">
        <div class="summary-box">
            <div class="summary-row">
                <span class="summary-label">商品代金</span>
                <span class="summary-value"><span class="yen">¥</span>{{ number_format($product->price ?? 0) }}</span>
            </div>

            <div class="summary-divider"></div>
            <div class="summary-row">
                <span class="summary-label">支払い方法</span>
                <span class="summary-value payment-summary">未選択</span>
            </div>
        </div>

        {{-- <form action="{{ route('purchase.confirm') }}" method="POST">--}}
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="payment_method" id="payment-method-hidden" value="">
        <button type="submit" class="purchase-button">購入する</button>
        </form>
    </section>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentSelect = document.querySelector('.payment-select');
        const paymentSummary = document.querySelector('.payment-summary');
        const paymentHidden = document.getElementById('payment-method-hidden');

        paymentSelect.addEventListener('change', function() {
            const selectedText = paymentSelect.options[paymentSelect.selectedIndex].text;
            const selectedValue = paymentSelect.value;

            paymentSummary.textContent = selectedText || '未選択';
            paymentHidden.value = selectedValue;
        });
    });
</script>