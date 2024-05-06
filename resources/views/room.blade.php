{{-- room.blade.php --}}
@extends('layout')

@section('content')
    <style>
        .room-image {
            width: 100%;
            height: auto;
        }
        .booking-form {
            max-width: 500px;
            margin: auto;
        }
        .review-form {
            max-width: 500px;
            margin: auto;
        }
        .carousel-control-prev, .carousel-control-next {
            width: 5%;
        }

        .carousel-item img {
            object-fit: contain;
            height: 100%;
            margin: auto;
        }
    </style>
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

            <div class="container mt-5">
                <h1>Номер {{ $room->number }}</h1>
                <div class="row">
                    <div class="col-md-10">
                        <div id="room-images" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($room->photos as $index => $photo)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset($photo->path) }}" class="d-block w-100 room-image" alt="Photo of room {{ $room->number }}">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#room-images" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Попередній</span>
                            </a>
                            <a class="carousel-control-next" href="#room-images" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Наступний</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <p><i class="fas fa-bed"></i> <strong>{{ $room->beds }} ліжок</strong></p>
                        <p><i class="fas fa-ruler-combined"></i> <strong>{{ $room->square_meters }} квадратних метрів</strong></p>
                        <p><i class="fas fa-money-bill-wave"></i> <strong>{{ $room->price_per_night }} за ніч</strong></p>
                        <div class="amenities">
                            @foreach($room->amenities as $amenity)
                                <span class="badge badge-primary">{{ $amenity->amenity }}</span>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#bookingModal">
                            Забронювати
                        </button>
                    </div>
                </div>
            </div>
        @if(auth('web')->id())
            <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookingModalLabel">Бронювання номеру</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <input type="hidden" name="user_id" value="{{ auth('web')->id() }}">
                                <div class="form-group">
                                    <label for="user_name">Ваше ім'я</label>
                                    <input id="user_name" name="user_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_contact">Ваші контакти</label>
                                    <input id="user_contact" name="user_contact" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="check_in_date">Дата заїзду</label>
                                    <input type="text" id="check_in_date" name="check_in_date" class="form-control datepicker" required>
                                </div>
                                <div class="form-group">
                                    <label for="check_out_date">Дата виїзду</label>
                                    <input type="text" id="check_out_date" name="check_out_date" class="form-control datepicker"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label for="guests">Кількість гостей</label>
                                    <input type="number" id="guests" name="guests" class="form-control" min="1" max="10" required>
                                </div>
                                <div class="form-group">
                                    <label for="payment_method_id">Тип оплати</label>
                                    <select class="form-control" id="payment_method_id" name="payment_method_id">
                                        @foreach($payment_methods as $payment_method)
                                            <option value="{{$payment_method->id}}">{{$payment_method->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Забронювати</button>
                                @if(!empty($booking->payment_confirm) && $booking->payment_confirm == 0)
                                    <a href="{{ route('booking.payment', ['bookingId' => $booking->id]) }}" class="btn btn-secondary">Оплатити</a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(auth('web')->id() && (empty($booking->payment_confirm) || $booking->payment_confirm == 1))
            <form action="{{ route('room.storeReview', $room->id) }}" method="POST" class="review-form mt-4">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="user_id" value="{{ auth('web')->id() }}">
                <div class="form-group">
                    <label for="review">Ваш відгук</label>
                    <textarea id="review" name="review" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="rating">Рейтинг</label>
                    <div id="rating" class="star-rating">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="rating{{ $i }}" name="rating" value="{{ $i }}" {{ request('rating') == $i ? 'checked' : '' }}/>
                            <label for="rating{{ $i }}" title="{{ $i }}"><i class="fas fa-star"></i></label>
                        @endfor
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Залишити відгук</button>
            </form>

        @endif
        @foreach($room->reviews as $review)
            <div class="card mb-3 mt-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $review->user->name }}</h5>
                    <p class="card-text">{{ $review->review }}</p>
                    <p class="card-text"><small class="text-muted"><i class="fas fa-star"></i> {{ $room->hotel->stars }} </small></p>
                    @if($review->response)
                        <p class="card-text"><strong>Відповідь адміністратора:</strong> {{ $review->response }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
