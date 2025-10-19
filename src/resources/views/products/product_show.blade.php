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
            <img src="{{ asset('storage/products/' . $product->image_path) }}" alt="商品画像" class="product-image">
        </div>

        <!-- 右グリッド：商品情報 -->
        <!-- 右グリッド：商品情報 -->
        <div class="product-summary">
            <h1 class="product-title">{{ $product->name }}</h1>
            <p class="product-brand">{{ $product->brand }}</p>
            <p class="product-price">¥{{ number_format($product->price) }} <span class="tax-included">（税込）</span></p>

            <div class="product-actions">
                <div class="action-block">
                    {{-- <button class="like-button">★</button> --}}
                    {{-- <span class="like-count">{{ $product->likes_count }}</span> --}}
                    <button class="like-button"><img src="{{ asset('images/star.png') }}" alt="☆"></button>
                    <span class="action-count">0</span>
                </div>

                <div class="action-block">
                    {{-- <span class="comment-icon">💬</span> --}}
                    {{-- <span class="comment-count">{{ $product->comments_count }}</span> --}}
                    <span class="comment-icon"><img src="{{ asset('images/comment.png') }}" alt="💬"></span>
                    <span class="action-count">0</span>
                </div>
            </div>

            <div class="product-button-area">
                <button class="purchase-button">購入手続きへ</button>
            </div>

            <div class="product-description-area">
                <h2 class="product-description-title">商品説明</h2>
                <p class="product-description-text">{{ $product->description }}</p>
            </div>

            <div class="product-info-area">
                <h2 class="product-info-title">商品の情報</h2>

                <div class="product-info-tags">
                    <div class="product-category-group">
                        <span class="info-label">カテゴリー</span>
                        <div class="category-tags">
                            <span class="category-tag">{{ $product->category }}</span>
                        </div>
                    </div>

                    <div class="product-condition-group">
                        <span class="info-label">商品の状態</span>
                        <span class="condition-text">{{ $product->condition }}</span>
                    </div>
                </div>
            </div>

            <div class="product-comment-area">
                <div class="comment-header">コメント（1）</div>

                <div class="comment-block">
                    <div class="comment-header-row">
                        <div class="comment-user-icon"></div>
                        <div class="comment-username">admin</div>
                    </div>
                    <div class="comment-text">こちらにコメントが入ります。</div>
                </div>


                <div class="comment-form-area">
                    <div class="comment-form-title">商品へのコメント</div>
                    <textarea class="comment-input" placeholder="コメントを入力してください..."></textarea>
                    <button class="comment-submit-button">コメントを送信する</button>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection