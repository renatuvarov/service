<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Service</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="outer_wrapper">
    <div class="inner_wrapper">
        <header class="header">
            <div class="container header_wrapper">
                <nav class="nav_menu header_menu">
                    <ul class="nav_menu-list">
                        @if (Route::has('login'))
                            <li class="nav_menu-item">
                                <a href="{{ route('main') }}" class="nav_menu-link">Главная</a>
                            </li>
                            @auth
                                <li class="nav_menu-item">
                                    <a href="{{ route('user.home') }}" class="nav_menu-link">Билеты</a>
                                </li>
                                <li class="nav_menu-item">
                                    <a href="{{ route('user.profile.index') }}" class="nav_menu-link">Профиль</a>
                                </li>
                                @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                                    <li class="nav_menu-item">
                                        <a href="{{ route('admin.main') }}" class="nav_menu-link">Админ</a>
                                    </li>
                                @endif
                                <li class="nav_menu-item">
                                    <form class="form nav_menu-link" method="post" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit">Выход</button>
                                    </form>
                                </li>
                            @else
                                <li class="nav_menu-item">
                                    <a href="{{ route('login') }}" class="nav_menu-link">Вход</a>
                                </li>

                                @if (Route::has('register'))
                                    <li class="nav_menu-item">
                                        <a href="{{ route('register') }}" class="nav_menu-link">Регистрация</a>
                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </nav>
            </div>

        </header>
        <main class="main">
            @yield('content')
        </main>
    </div>
    <footer class="footer"><a href="https://vk.com/id500210142">Ренат Уваров</a> {{ date('Y') }} &copy;</footer>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>