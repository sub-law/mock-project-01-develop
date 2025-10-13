@extends('layouts.app')

@section('title', '商品詳細')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/product_show.css') }}">
@endsection

@section('content')
<div class="product-detail-container">
    <div class="product-detail-grid">
        <!-- 左グリッド：商品画像 -->
        <div class="product-image-area">
            <img src="{{ asset('storage/products/sample.jpg') }}" alt="商品画像" class="product-image">
        </div>

        <!-- 右グリッド：商品情報 -->
        <div class="product-info-area">
            <h1 class="product-title">商品名がここに入る</h1>
            <p class="product-price">¥47,000 <span class="tax-included">（税込）</span></p>
            <button class="purchase-button">購入手続きへ</button>

            <div class="product-description">
                <h2>商品説明</h2>
                <p>カラー：グレー</p>
                <p>商品の特徴や説明が入ります。特にありません。</p>
            </div>
            @endsection