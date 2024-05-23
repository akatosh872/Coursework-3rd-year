{{-- room.blade.php --}}
@extends('layout')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="container mt-5">
            <h1>Номер {{ $room->number }}</h1>
            <div id="room-images" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($room->photos as $index => $photo)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset($photo->path) }}" class="d-block w-100 room-image"
                                 alt="Photo of room {{ $room->number }}">
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

            <div class="row mt-4">
                <div class="col-md-8">
                    <h2>{{ $room->hotel->name }}</h2>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $room->hotel->location }}</p>
                    <p><i class="fas fa-star"></i> {{ $room->hotel->stars }} Stars</p>
                    <p><i class="fas fa-bed"></i> {{ $room->beds }} ліжок</p>
                    <p><i class="fas fa-ruler-combined"></i> {{ $room->square_meters }} квадратних метрів</p>
                    <p><i class="fas fa-money-bill-wave"></i> {{ $room->price_per_night }} за ніч</p>
                </div>
                @if(auth('web')->id() && !$reserved)
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary mt-4" data-toggle="modal"
                                data-target="#bookingModal">
                            Забронювати
                        </button>
                        @if(!empty($booking) && $booking->payment_confirm != 1)
                            <a href="{{ route('booking.payment', ['bookingId' => $booking->id]) }}"
                               class="btn btn-secondary mt-4">Оплатити</a>
                        @endif
                    </div>
                @endif
            </div>

            @if(!empty($room->amenities{0}))
                <div class="row mt-4">
                    <div class="col-12">
                        <h3>Зручності</h3>
                        <div class="d-flex flex-wrap">
                            @foreach($room->amenities as $amenity)
                                <div class="p-2 flex-fill bd-highlight">
                                    <div class="amenity text-white bg-primary mb-3">
                                        <div class="card-body">
                                            <p class="card-text">{{ $amenity->amenity }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if(auth('web')->id())
                <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog"
                     aria-labelledby="bookingModalLabel" aria-hidden="true">
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
                                        <input id="user_name" name="user_name"
                                               class="form-control @error('user_name') is-invalid @enderror"
                                               value="{{ old('user_name') }}" required>
                                        @error('user_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="user_contact">Ваші контакти</label>
                                        <input id="user_contact" name="user_contact"
                                               class="form-control @error('user_contact') is-invalid @enderror"
                                               value="{{ old('user_contact') }}" required>
                                        @error('user_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="check_in_date">Дата заїзду</label>
                                        <input type="date" id="check_in_date" name="check_in_date"
                                               class="form-control datepicker @error('check_in_date') is-invalid @enderror"
                                               value="{{ old('check_in_date') }}" required>
                                        @error('check_in_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="check_out_date">Дата виїзду</label>
                                        <input type="date" id="check_out_date" name="check_out_date"
                                               class="form-control datepicker @error('check_out_date') is-invalid @enderror"
                                               value="{{ old('check_out_date') }}" required>
                                        @error('check_out_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="guests">Кількість гостей</label>
                                        <input type="number" id="guests" name="guests"
                                               class="form-control @error('guests') is-invalid @enderror"
                                               value="{{ old('guests') }}" min="1" max="10" required>
                                        @error('guests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_method_id">Тип оплати</label>
                                        <select class="form-control @error('payment_method_id') is-invalid @enderror"
                                                id="payment_method_id" name="payment_method_id">
                                            @foreach($payment_methods as $payment_method)
                                                <option
                                                    value="{{$payment_method->id}}" {{ old('payment_method_id') == $payment_method->id ? 'selected' : '' }}>{{$payment_method->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('payment_method_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Забронювати</button>
                                    @if(!empty($booking->payment_confirm) && $booking->payment_confirm == 0)
                                        <a href="{{ route('booking.payment', ['bookingId' => $booking->id]) }}"
                                           class="btn btn-secondary">Оплатити</a>
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
                                <input type="radio" id="rating{{ $i }}" name="rating"
                                       value="{{ $i }}" {{ request('rating') == $i ? 'checked' : '' }}/>
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
                        <p class="card-text"><small class="text-muted"><i
                                    class="fas fa-star"></i> {{ $room->hotel->stars }} </small></p>
                        @if($review->response)
                            <p class="card-text"><strong>Відповідь адміністратора:</strong> {{ $review->response }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
@endsection
