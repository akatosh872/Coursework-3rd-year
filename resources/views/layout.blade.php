{{-- layout.blade.php --}}
    <!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бронювання готелів</title>
    {{-- Підключення Bootstrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

{{-- Хедер сайту --}}
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">HotelBooking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('welcome') }}">Головна</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hotels.show') }}">Готелі</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rooms.show') }}">Пошук номерів</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Реєстрація</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Вхід</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{route('personal.cabinet')}}" class="nav-link">Особистий кабінет</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Вийти
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>

{{-- Основний вміст сайту --}}
<main>
    @yield('content')
</main>

{{-- Футер сайту --}}
<footer class="bg-light text-center text-lg-start">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2024 HotelBooking. Всі права захищені.
    </div>
</footer>

{{-- Підключення jQuery --}}
<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
{{-- Підключення Bootstrap JS --}}
<script type="text/javascript" charset="utf8" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
{{-- Підключення FancyBox --}}
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
{{-- Підключення DataTables --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script>
    $( function() {
        $( ".datepicker" ).datepicker({
            dateFormat: "yy-mm-dd"
        });
    } );
</script>
<style>
    .star-rating {
        display: inline-block;
        font-size: 0;
    }
    .star-rating__ico:hover:before,
    .star-rating__ico:hover ~ .star-rating__ico:before,
    .star-rating__input:checked ~ .star-rating__ico:before
    {
        content: "\f005";
    }
    .star-rating {
        direction: rtl;
        display: inline-block;
        padding: 0;
        margin: 0;
    }

    .star-rating input[type=radio] {
        display: none;
    }

    .star-rating label {
        color: #ddd;
        font-size: 20px;
        padding: 0;
        cursor: pointer;
        transition: color .2s;
    }

    .star-rating input[type=radio]:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffd700;
    }
    .pagination .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination .page-item .page-link svg {
        width: 1em;
        height: 1em;
    }

</style>

@yield('scripts')
</body>
</html>
