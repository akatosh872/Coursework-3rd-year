@extends('admin.layout')

@section('content')
    <div class="container">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h1>Всі бронювання</h1>
        <table class="table table-striped" id="myTable">
            <thead>
            <tr>
                <th>Номер</th>
                <th>Ім'я клієнта</th>
                <th>Контакт з клієнтом</th>
                <th>Дата заїзду</th>
                <th>Дата виїзду</th>
                <th>Кількість гостей</th>
                <th>Оплата</th>
                <th>Статус оплати</th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->room->number }}</td>
                    <td>{{ $booking->user_name }}</td>
                    <td>{{ $booking->user_contact }}</td>
                    <td>{{ $booking->check_in_date }}</td>
                    <td>{{ $booking->check_out_date }}</td>
                    <td>{{ $booking->guests }}</td>
                    <td>{{ $booking->payment_method->name }}</td>
                    <td>{{ $booking->payment_confirm }}</td>
                    <td>
                        <a href="{{ route('admin.booking.show', $booking->id) }}" class="btn btn-primary">Редагувати</a>
                        <form action="{{ route('admin.booking.delete', $booking->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
           $('#myTable').DataTable();
        });
    </script>
@endsection
