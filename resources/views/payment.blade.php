{{-- payment.blade.php --}}
@extends('layout')

@section('content')
    <div class="container">
        <h2>Оплата</h2>
        <h3>Інформація про бронювання</h3>
        <p>Назва готелю: {{ $booking->room->hotel->name }}</p>
        <p>Номер: {{ $booking->room->number }}</p>
        <p>Дата заїзду: {{ $booking->check_in_date }}</p>
        <p>Дата виїзду: {{ $booking->check_out_date }}</p>
        <p>Ім'я користувача: {{ $booking->user_name }}</p>
        <p>Контакт користувача: {{ $booking->user_contact }}</p>
        <p>Кількість гостей: {{ $booking->guests }}</p>

        <h3>Оплата</h3>
        <form action="{{ route('payment.confirm', $booking->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="cardNumber">Номер картки</label>
                <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
            </div>
            <div class="form-group">
                <label for="amount">Сума</label>
                <input type="text" class="form-control" id="amount" name="amount" required>
            </div>
            <button type="submit" class="btn btn-primary">Підтвердити оплату</button>
        </form>
    </div>
@endsection
