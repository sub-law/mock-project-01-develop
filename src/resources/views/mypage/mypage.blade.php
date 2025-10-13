@extends('layouts.app')

@section('title', 'マイページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<div class="mypage-wrapper">
    <div class="profile-box">
        <div class="profile-content">
            <img src="{{ asset('storage/products/bag.jpg') }}" alt="プロフィール画像" class="profile-icon">
            <p class="profile-name">ユーザー名</p>
        </div>
        <a href="{{ route('mypage.profile_edit') }}" class="edit-button">プロフィールを編集</a>
    </div>
</div>

<div class="product-tabs">
    <h2 class="section-title active" data-tab="selling">出品した商品</h2>
    <h2 class="section-title" data-tab="purchased">購入した商品</h2>
</div>

<div class="product-contents">
    <div class="product-list selling-list active">
        {{-- 出品した商品 --}}
    </div>

    <div class="product-list purchased-list">
        {{-- 購入した商品 --}}
    </div>
</div>


<div class="product-list-wrapper">
    <div class="product-list">
        @foreach(range(1, 9) as $i)
        <div class="product-card">
            <div class="product-image-box">
                <img src="{{ asset('storage/products/bag.jpg') }}" alt="商品画像">
                <div class="product-name">商品名 {{ $i }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection