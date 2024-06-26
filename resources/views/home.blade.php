{{-- home.blade.php --}}
@extends('layout')

@section('content')
    <div class="container-fluid p-0">
        <div class="jumbotron jumbotron-fluid bg-primary text-white text-center">
            <div class="container py-5">
                <h1 class="display-4">Ласкаво просимо до HotelBooking!</h1>
                <p class="lead">Найкращий сервіс для бронювання готелів у світі.</p>
                <hr class="my-4 bg-light">
                <p>Знайдіть ідеальний готель для своєї подорожі за лічені хвилини.</p>
                <form action="{{ route('rooms.search') }}" method="GET" class="form-inline justify-content-center">
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Адреса" name="query">
                    <input type="text" class="form-control datepicker mb-2 mr-sm-2" placeholder="Дата заїзду" name="check_in_date">
                    <input type="text" class="form-control datepicker mb-2 mr-sm-2" placeholder="Дата виїзду" name="check_out_date">
                    <button type="submit" class="btn btn-light mb-2">Пошук готелів</button>
                </form>
            </div>
        </div>

        <div class="container mt-5">
            <h2 class="mb-3">Популярні готелі</h2>
            <div class="row">
                @foreach($hotels as $hotel)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="{{ asset($hotel->photo) }}" class="card-img-top" alt="{{ $hotel->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $hotel->name }}</h5>
                                <p class="card-text">{{ Str::limit($hotel->description, 100, '...') }}</p> <!-- Використовуємо Str::limit для обмеження тексту -->
                                <a href="{{ route('hotels.list', $hotel->id) }}" class="btn btn-primary">Детальніше</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img src="stock/hotel.jpg" class="card-img-top" alt="Hotel image">
                    <div class="card-body">
                        <h5 class="card-title">Широкий вибір готелів</h5>
                        <p class="card-text">Ми пропонуємо великий вибір готелів по всьому світу. Знайдіть той, який вам найбільше подобається.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <img src="stock/room.jpg" class="card-img-top" alt="Room image">
                    <div class="card-body">
                        <h5 class="card-title">Комфортні номери</h5>
                        <p class="card-text">Наші готелі пропонують комфортні номери з усіма зручностями для вашого відпочинку.</p>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="accordion container mt-5" id="featuresAccordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Швидке бронювання
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#featuresAccordion">
                    <div class="card-body">
                        Бронюйте готелі в декілька кліків. Наш процес бронювання простий та зручний.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Надійність та безпека
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#featuresAccordion">
                    <div class="card-body">
                        Ми гарантуємо безпеку вашої інформації та платежів. Ви можете довіряти нам.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Підтримка 24/7
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#featuresAccordion">
                    <div class="card-body">
                        Наша команда підтримки завжди готова допомогти вам з будь-якими питаннями або проблемами.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0, // Не дозволяти вибрати дату раніше сьогоднішньої
                onSelect: function(selectedDate) {
                    if ($(this).hasClass('check_in_date')) {
                        var endDate = $(this).closest('form').find('.check_out_date');
                        endDate.datepicker('option', 'minDate', selectedDate); // Встановлюємо мінімальну доступну дату
                        endDate.prop('disabled', false);
                    }
                }
            });
        });
    </script>
@endsection
