@extends('layout')

@section('content')
    <div class="container">
        <h2>Особистий кабінет</h2>
        <h3>Ваші бронювання</h3>
        @if(count($bookings) > 0)
            <table class="table table-striped display" id="myTable">
                <thead>
                <tr>
                    <th>Назва готелю</th>
                    <th>Номер</th>
                    <th>Дата заїзду</th>
                    <th>Дата виїзду</th>
                    <th>Ім'я користувача</th>
                    <th>Контакт користувача</th>
                    <th>Кількість гостей</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td><a href="{{route('hotel.show', $booking->room->hotel->id)}}">{{ $booking->room->hotel->name }}</a></td>
                        <td><a href="{{route('room.show', $booking->room->id)}}">{{ $booking->room->number }}</a></td>
                        <td>{{ $booking->check_in_date }}</td>
                        <td>{{ $booking->check_out_date }}</td>
                        <td>{{ $booking->user_name }}</td>
                        <td>{{ $booking->user_contact }}</td>
                        <td>{{ $booking->guests }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>У вас немає бронювань.</p>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        });
    </script>
@endsection
