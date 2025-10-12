@extends('layouts.app')

@section('title', '商品出品画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/sell_form.css') }}">
@endsection

@section('content')

<div class="form-wrapper">
    <h1 class="form-title">商品の出品</h1>

    {{-- <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"> --}}
    <form method="POST" action="#" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-message">商品画像</div>
        <div class="form-image-box">
            <label for="product_image" class="form-image-button-centered">画像を選択する</label>
            <input type="file" id="product_image" name="product_image" class="form-image-input" accept="image/*" hidden>
        </div>


        {{-- カテゴリー選択 --}}
        <div class="form-category-wrapper">
            <div class="form-message-title">商品の詳細</div>
            <div class="form-message-category">カテゴリー</div>
            <div class="category-tags">
                @foreach(['ファッション','家電','インテリア','レディース','メンズ','コスメ','本','ゲーム','スポーツ','キッチン','ハンドメイド','アクセサリー','おもちゃ','ベビー・キッズ'] as $category)
                <label class="category-tag">
                    <input type="checkbox" name="categories[]" value="{{ $category }}">
                    <span>{{ $category }}</span>
                </label>
                @endforeach
            </div>
            {{-- 商品の状態 --}}
            <label class="form-label" for="condition">商品の状態</label>
            <select id="condition" name="condition" class="form-input">
                <option value="">選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
        </div>

        {{-- 商品名・ブランド名 --}}
        <div class="form-message-title">商品名と説明</div>
        <label class="form-label" for="name">商品名</label>
        <input type="text" id="name" name="name" class="form-input">

        <label class="form-label" for="brand">ブランド名</label>
        <input type="text" id="brand" name="brand" class="form-input">

        {{-- 商品説明 --}}
        <label class="form-label" for="description">商品の説明</label>
        <textarea id="description" name="description" class="form-input" rows="5" style="resize: vertical;"></textarea>

        {{-- 販売価格 --}}
        <label class="form-label" for="price">販売価格</label>
        <div class="form-input-with-symbol">
            <span class="yen-symbol">￥</span>
            <input type="number" id="price" name="price" class="form-input price-input">
        </div>

        {{-- 出品ボタン --}}
        <button type="submit" class="form-button">出品する</button>
    </form>
</div>

@endsection