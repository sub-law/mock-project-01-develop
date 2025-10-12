@extends('layouts.app')

@section('title', 'プロフィール設定画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">プロフィール設定</h1>

    <!-- プロフィール画像のプレースホルダー -->
    {{-- <form method="POST" action="{{ route('profile.update') }}"> --}}
    <form method="POST" action="#" enctype="multipart/form-data">
        @csrf

        <div class="form-image-area">
            <div class="form-image-wrapper">
                <div class="form-image-placeholder" id="imagePreview"></div>
                <label for="profile_image" class="form-image-button">画像を選択する</label>
                <input type="file" id="profile_image" name="profile_image" class="form-image-input" accept="image/*" hidden>
            </div>
        </div>

        <label for="username" class="form-label">ユーザー名</label>
        <input type="text" id="username" name="username" class="form-input" required>

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