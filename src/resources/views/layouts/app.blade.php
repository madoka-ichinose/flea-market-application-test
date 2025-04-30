<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Management</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  @yield('css')
</head>

<body>
  <header class="header">
   <div class="header__inner">
    <div class="header-utilities">
        <a class="header__logo" href="/">
            COACHTECH
        </a>

        @php
            $currentRoute = Route::currentRouteName();
        @endphp

       
        @if (!in_array($currentRoute, ['login', 'register']))
        <div class="search-box">
            <form action="{{ route('products.search') }}" method="GET">
            <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
            </form>
        </div>
        @endif

        @if (!in_array($currentRoute, ['login', 'register']))
        <nav>
            <ul class="header-nav">
            @if (Auth::check())
                <li class="header-nav__item">
                    <form class="form" action="/logout" method="post">
                    @csrf
                    <button class="header-nav__button">ログアウト</button>
                    </form>
                </li>
                <li class="header-nav__item">
                    <a class="header-nav__link" href="/mypage">マイページ</a>
                </li>
                <li class="header-nav__item">
                    <a class="header-nav__link" href="/sell">出品</a>
                </li>
                @else
                <li class="header-nav__item">
                <a class="header-nav__link" href="/login">ログイン</a>
                </li>
                <li class="header-nav__item">
                <a class="header-nav__link" href="/mypage">マイページ</a>
                </li>
                <li class="header-nav__item">
                <a class="header-nav__link" href="/sell">出品</a>
                </li>
            @endif
             </ul>
        </nav>
        @endif
    </div>
   </div>
  </header>

  <main>
    @yield('content')
  </main>
  @yield('js')
  @yield('script')
</body>

</html>
