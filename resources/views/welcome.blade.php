{{-- welcome.blade.php --}}
@extends('layout')

@section('content')
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Ласкаво просимо до HotelBooking!</h1>
            <p class="lead">Найкращий сервіс для бронювання готелів у світі.</p>
            <hr class="my-4">
            <p>Знайдіть ідеальний готель для своєї подорожі за лічені хвилини.</p>
            <a class="btn btn-primary btn-lg" href="{{ route('hotels.show') }}" role="button">Пошук готелів</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img src="images/hotel.jpg" class="card-img-top" alt="Hotel image">
                    <div class="card-body">
                        <h5 class="card-title">Широкий вибір готелів</h5>
                        <p class="card-text">Ми пропонуємо великий вибір готелів по всьому світу. Знайдіть той, який вам найбільше подобається.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <img src="images/room.jpg" class="card-img-top" alt="Room image">
                    <div class="card-body">
                        <h5 class="card-title">Комфортні номери</h5>
                        <p class="card-text">Наші готелі пропонують комфортні номери з усіма зручностями для вашого відпочинку.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion mt-5" id="featuresAccordion">
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
