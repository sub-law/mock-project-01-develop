@extends('layouts.app')

@section('title', '送付先住所変更画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">住所の変更</h1>

    <!-- プロフィール画像のプレースホルダー -->
    {{-- <form method="POST" action="{{ route('profile.update') }}"> --}}
    <form method="POST" action="#" enctype="multipart/form-data">
        @csrf

        <label for="postal_code" class="form-label">郵便番号</label>
        <input type="text" id="postal_code" name="postal_code" class="form-input" required>

        <label for="address" class="form-label">住所</label>
        <input type="text" id="address" name="address" class="form-input" required>

        <label for="building" class="form-label">建物名</label>
        <input type="text" id="building" name="building" class="form-input">

        <button type="submit" class="form-button">更新する</button>
    </form>
</div>
@endsection