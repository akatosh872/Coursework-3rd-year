{{-- admin-layout.blade.php --}}
    <!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адмін Панель</title>
    {{-- Підключення Bootstrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

{{-- Хедер адмін панелі --}}
<header class="admin-header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Адмінка</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                {{-- Навігація адмін панелі --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin.welcome') }}">Головна</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.hotel_create') }}">Створити готель</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.hotels.show') }}">Готелі</a>
                    </li>
                </ul>
                {{-- Вихід з адмін панелі --}}
                <ul class="navbar-nav ml-auto">
                    @guest('admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.login') }}">Вхід</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Вийти
                            </a>

                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>


            </div>
        </div>
    </nav>
</header>

{{-- Основний контент --}}
<div class="admin-content">
    @yield('content')
</div>

{{-- Футер адмін панелі --}}
<footer class="admin-footer bg-primary text-white text-center p-3">
    © 2024 Адмін Панель. Всі права захищені.
</footer>

{{-- Підключення Bootstrap JS --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
