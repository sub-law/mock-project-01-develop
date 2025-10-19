@extends('layouts.app')

@section('title', '商品一覧')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="tab-wrapper">
    <div class="tab-menu">
        <a href="{{ route('index') }}" class="{{ request('tab') !== 'mylist' ? 'tab-active' : 'tab' }}">おすすめ</a>
        <a href="{{ route('index', ['tab' => 'mylist']) }}" class="{{ request('tab') === 'mylist' ? 'tab-active' : 'tab' }}">マイリスト</a>
    </div>

    <div class="product-row">
        @foreach ($products as $product)
        <a href="{{ route('product_show', ['item_id' => $product->id]) }}" class="product-card">
            <img src="{{ asset('storage/products/' . $product->image_path) }}" alt="商品画像" class="product-image">
            <p class="product-name">{{ $product->name }}</p>
        </a>
        @endforeach
    </div>

</div>
@endsection