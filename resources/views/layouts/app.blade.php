<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="{{ asset('css/styles.css') }}?ver=1">
    <link rel="stylesheet" media="all" href="{{ asset('css/footer.css') }}?ver=1">
    <link rel="stylesheet" media="all" href="{{ asset('css/header.css') }}?ver=1">
    <link rel="stylesheet" media="all" href="{{ asset('css/login.css') }}?ver=1">
    @vite(['resources/assets/css/app.css', 'resources/assets/scss/app.scss', 'resources/assets/js/app.js', 'resources/assets/js/bootstrap.js'])
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <title>Инструкции для техники</title>
</head>
<body>

<header class="transparent-header">
    <div class="container">
        <nav class="navbar">
            <ul class="navbar-menu-header">
                <li><a href="{{ url('/') }}">Главная</a></li>
                <li><a href="#">О нас</a></li>
                <li><a href="#">Политика</a></li>
            </ul>
            <ul class="navbar-auth-header">
                @auth
                    <li><a href="/profile">{{ auth()->user()->name }}</a></li>
                    <li><a href="">|</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn-link-header" type="submit">Выход</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Войти</a></li>
                    <li><a href="">|</a></li>
                    <li><a href="{{ route('register') }}">Регистрация</a></li>
                @endauth
            </ul>
        </nav>
    </div>
</header>

<main class="main">
    @yield('content')
</main>

<footer>
    <ul class="social">
        <li><a href="#"><ion-icon name="logo-facebook"></ion-icon></a></li>
        <li><a href="#"><ion-icon name="logo-twitter"></ion-icon></a></li>
        <li><a href="#"><ion-icon name="logo-linkedin"><ion-icon></a></li>
        <li><a href="#"><ion-icon name="logo-instagram"></ion-icon></a></li>
    </ul>
    <p>©{{ date('Y') }} ООО 'Дима' | Все права защещены</p>
</footer>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>
