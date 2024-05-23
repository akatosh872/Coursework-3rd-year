{{-- payment.blade.php --}}
@extends('layout')

@section('content')
    <div class="container">
        <h3>Інформація про бронювання</h3>
        <p>Назва готелю: {{ $booking->room->hotel->name }}</p>
        <p>Номер: {{ $booking->room->number }}</p>
        <p>Дата заїзду: {{ $booking->check_in_date }}</p>
        <p>Дата виїзду: {{ $booking->check_out_date }}</p>
        <p>Ім'я користувача: {{ $booking->user_name }}</p>
        <p>Контакт користувача: {{ $booking->user_contact }}</p>
        <p>Кількість гостей: {{ $booking->guests }}</p>

        @php
            // Перетворюємо рядки у відповідні дати
        $checkInDate = new DateTime($booking->check_in_date);
        $checkOutDate = new DateTime($booking->check_out_date);

        // Обчислюємо різницю у датах для отримання кількості днів
        $interval = $checkOutDate->diff($checkInDate);

        // Отримуємо кількість днів у цілочисельному форматі
        $numberOfDays = $interval->days;

        // Обчислюємо вартість до оплати
        $totalCost = $booking->room->price_per_night * $numberOfDays;
        @endphp
        <h3>До оплати {{$totalCost}} грн</h3>
        <form action="{{ route('payment.confirm', $booking->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="cardNumber">Номер картки (наприклад 4539 1488 0343 6467)</label>
                <input type="text" class="form-control @error('cardNumber') is-invalid @enderror" id="cardNumber" value="{{old('cardNumber')}}" name="cardNumber" required>
                @error('cardNumber')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="amount">Сума</label>
                <input type="text" class="form-control @error('amount') is-invalid @enderror" id="amount" value="{{old('amount')}}" name="amount" required>
                @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Підтвердити оплату</button>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $('#cardNumber').payment('formatCardNumber'); // Маска для номера картки
            $('#cardNumber').on('input', function() {
                $(this).val(function(index, value) {
                    return value.replace(/\D/g, '').replace(/(^\d{4})(?=\d)/g, '$1 ');
                });
            });

            $('form').submit(function(event) {
                var cardNumber = $('#cardNumber').val();
                if ($.payment.validateCardNumber(cardNumber)) {
                    return true; // Продовжити зі введеним номером картки
                } else {
                    alert('Будь ласка, введіть коректний номер картки.');
                    event.preventDefault(); // Зупинити відправку форми
                }
            });
        });
    </script>
@endsection
