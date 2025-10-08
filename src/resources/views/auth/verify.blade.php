@extends('layouts.login')

@section('title', 'メール認証のお願い')

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">メール認証のお願い</h1>

    <p class="form-message">
        登録していただいたメールアドレスに認証メールをお送りしました。<br>
        メール認証を完了してください。
    </p>

    {{-- <a href="{{ route('verification.notice') }}" class="form-button-link">認証はこちらから</a> --}}

    {{-- <form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="form-button-secondary">認証メールを再送する</button>
    </form> --}}
</div>
@endsection