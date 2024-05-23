@extends('layout')

@section('content')
    <div class="container">
        <h3>Ваші бронювання</h3>
        @if(count($bookings) > 0)
            <input class="form-control" id="searchInput" type="text" placeholder="Пошук за бронюваннями">
            <br>
            <div class="row" id="bookingCards">
                @foreach($bookings as $booking)
                    <div class="col-md-4 booking-card">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-hotel"></i> {{ $booking->room->hotel->name }}</h5>
                                <p class="card-text">
                                    <strong>Номер:</strong> {{ $booking->room->number }}<br>
                                    Дата заїзду: <span class="{{ \Carbon\Carbon::parse($booking->check_in_date)->isFuture() ? 'text-success' : '' }}">{{ $booking->check_in_date }}</span><br>
                                    Дата виїзду: {{ $booking->check_out_date }}<br>
                                    <i class="fas fa-user"></i> {{ $booking->user_name }}<br>
                                    <i class="fas fa-phone"></i> {{ $booking->user_contact }}<br>
                                    <i class="fas fa-users"></i> Гостей {{ $booking->guests }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>У вас немає бронювань.</p>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#bookingCards .booking-card").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
