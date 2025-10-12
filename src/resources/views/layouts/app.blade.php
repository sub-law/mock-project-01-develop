<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COACHTECH')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @yield('styles')
</head>

<body>
    <header class="header">
        <div class="header-inner">
            <div class="header-left">
                <img src="{{ asset('images/logo.svg') }}" alt="COACHTECHロゴ">
            </div>

            <div class="header-center">
                <form action="/search" method="GET" class="search-form">
                    <input type="text" name="query" placeholder="何をお探しですか？" class="search-input">
                </form>
            </div>

            <div class="header-right">
                {{-- @auth --}}
                <a href="{{ route('logout') }}" class="header-link">ログアウト</a>
                <a href="{{ route('mypage') }}" class="header-link">マイページ</a>
                <a href="{{ route('sell') }}" class="header-button">出品</a>
                {{-- @else --}}
                <a href="{{ route('login') }}" class="header-link">ログイン</a>
                {{-- @endauth --}}
            </div>
        </div>
    </header>

    @yield('content')
</body>

</html>