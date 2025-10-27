@extends('layouts.app')

@section('title', '商品詳細')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/product_show.css') }}">
@endsection

@section('content')
<div class="product-detail-container">
    <div class="product-detail-grid">
        
        <div class="product-image-area">
            <img src="{{ asset('storage/products/' . $product->image_path) }}" alt="商品画像" class="product-image">
            @if ($product->is_sold)
            <div class="sold-label">SOLD</div>
            @endif
        </div>

        <div class="product-summary">
            <h1 class="product-title">{{ $product->name }}</h1>
            <p class="product-brand">{{ $product->brand }}</p>
            <p class="product-price">¥{{ number_format($product->price) }} <span class="tax-included">（税込）</span></p>

            <div class="product-actions">
                <div class="action-block">
                    @auth
                    <button class="like-button {{ $isFavorited ? 'liked' : '' }}" data-product-id="{{ $product->id }}">
                        <img src="{{ asset($isFavorited ? 'images/star.on.png' : 'images/star.png') }}" alt="お気に入りボタン">
                    </button>
                    <span class="action-count">{{ $product->favorites->count() }}</span>
                    @endauth

                    @guest
                    <a href="{{ route('login') }}" class="like-button">
                        <img src="{{ asset('images/star.png') }}" alt="お気に入りボタン">
                    </a>
                    <span class="action-count">{{ $product->favorites->count() }}</span>
                    @endguest
                </div>

                <div class="action-block">
                    <img src="{{ asset('images/comment.png') }}" alt="💬">
                    <span class="action-count">{{ $product->comments->count() }}</span>
                </div>
            </div>

            <div class="product-button-area">
                @auth
                @if (Auth::id() !== $product->seller_id)
                @if (!$product->is_sold)
                <a href="{{ route('purchase', ['item_id' => $product->id]) }}" class="purchase-button">購入手続きへ</a>
                @else
                <button class="purchase-button disabled" disabled>ただいま品切れ</button>
                @endif
                @endif
                @endauth

                @guest
                @if (!$product->is_sold)
                <a href="{{ route('login') }}" class="purchase-button">購入手続きへ</a>
                @else
                <button class="purchase-button disabled" disabled>ただいま品切れ</button>
                @endif
                @endguest
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
                <div class="comment-header">コメント（{{ $product->comments->count() }}）</div>

                @foreach ($product->comments as $comment)
                <div class="comment-block">
                    <div class="comment-header-row">
                        <div class="comment-user-icon">
                            @if (!empty($comment->user->profile_image))
                            <img src="{{ asset('storage/profile_images/' . $comment->user->profile_image) }}" alt="ユーザー画像">
                            @else
                            <img src="{{ asset('images/default-user.png') }}" alt="デフォルト画像">
                            @endif
                        </div>

                        <div class="comment-username">{{ $comment->user->name }}</div>
                    </div>
                    <div class="comment-text">{{ $comment->content }}</div>
                </div>
                @endforeach

                <div class="comment-form-area">
                    <div class="comment-form-title">商品へのコメント</div>

                    @auth
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <textarea name="content" class="comment-input" placeholder="コメントを入力してください..."></textarea>

                        @error('content')
                        <div class="form-error">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="comment-submit-button">コメントを送信する</button>
                    </form>
                    @endauth

                    @guest
                    <a href="{{ route('login') }}" class="comment-submit-button">ログインしてコメントする</a>
                    @endguest
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const likeButton = document.querySelector('.like-button');
        const actionCount = likeButton.nextElementSibling;
        const starImg = likeButton.querySelector('img');

        likeButton.addEventListener('click', function() {
            const productId = this.dataset.productId;

            fetch('/favorite/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'added') {
                        likeButton.classList.add('liked');
                        starImg.src = "{{ asset('images/star.on.png') }}";
                        actionCount.textContent = parseInt(actionCount.textContent) + 1;
                    } else if (data.status === 'removed') {
                        likeButton.classList.remove('liked');
                        starImg.src = "{{ asset('images/star.png') }}";
                        actionCount.textContent = parseInt(actionCount.textContent) - 1;
                    }
                });
        });
    });
</script>