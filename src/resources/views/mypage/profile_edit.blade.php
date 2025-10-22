@extends('layouts.app')

@section('title', 'プロフィール編集画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="form-wrapper">
        <h1 class="form-title">プロフィール設定</h1>

        <form method="POST" action="{{ route('mypage.profile.edit') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-image-area">
                <div class="form-image-wrapper">
                    <div class="form-image-placeholder" id="imagePreview">
                        @if ($user->profile_image)
                        <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}"
                            alt="現在のプロフィール画像"
                            style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 2px solid #FF5555;">
                        @endif
                    </div>
                    <label for="profile_image" class="form-image-button">画像を選択する</label>
                    <input type="file" id="profile_image" name="profile_image" class="form-image-input" accept="image/*" hidden>
                    @error('profile_image')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <label for="name" class="form-label">ユーザー名</label>
            <input type="text" id="name" name="name" class="form-input"
                value="{{ old('name', $user->name) }}">
            @error('name')
            <div class="form-error">{{ $message }}</div>
            @enderror

            <label for="postal_code" class="form-label">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" class="form-input"
                value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code')
            <div class="form-error">{{ $message }}</div>
            @enderror

            <label for="address" class="form-label">住所</label>
            <input type="text" id="address" name="address" class="form-input"
                value="{{ old('address', $user->address) }}">
            @error('address')
            <div class="form-error">{{ $message }}</div>
            @enderror

            <label for="building" class="form-label">建物名</label>
            <input type="text" id="building" name="building" class="form-input"
                value="{{ old('building', $user->building) }}">

            <button type="submit" class="form-button">更新する</button>
        </form>
    </div>

    <script>
        document.getElementById('profile_image').addEventListener('change', function(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="プレビュー画像" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 2px solid #FF5555;">`;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = ''; // 非画像なら空に
            }
        });
    </script>
@endsection