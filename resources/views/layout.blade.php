{{-- layout.blade.php --}}
    <!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бронювання готелів</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}?v={{time()}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

{{-- Хедер сайту --}}
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand d-none d-lg-block" href="#"><img src="/logo.png" alt="Logo" style="height: 30px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}"><i class="fas fa-home"></i> Головна</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hotels.list') }}"><i class="fas fa-hotel"></i> Готелі</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rooms.list') }}"><i class="fas fa-search"></i> Пошук номерів</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-login-register" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Реєстрація</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-login-register" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Вхід</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{route('personal.cabinet')}}" class="nav-link"><i class="fas fa-user"></i> Особистий кабінет</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Вийти
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

<footer class="text-center text-lg-start">
    <div class="text-center p-3" style="background-color: #007bff; color: #fff;">
        © 2024 HotelBooking. Всі права захищені.
    </div>
</footer>

{{-- Підключення jQuery --}}
<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.min.js"></script>
{{-- Підключення Bootstrap JS --}}
<script type="text/javascript" charset="utf8" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
{{-- Підключення FancyBox --}}
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
{{-- Підключення DataTables --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script>
    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0, // не дозволяти вибрати дату раніше сьогоднішньої
            onSelect: function(selectedDate) {
                if ($(this).hasClass('check_in_date')) {
                    var endDate = $(this).closest('form').find('.check_out_date');
                    endDate.datepicker('option', 'minDate', selectedDate);
                    endDate.prop('disabled', false);
                }
            }
        });
    });
</script>
@yield('scripts')
</body>
</html>
