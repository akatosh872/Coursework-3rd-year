@extends('admin.layout')

@section('content')
    <div class="container">
        <h1>Редагувати бронювання</h1>
        <form action="{{ route('admin.booking.edit', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="user_name">Ім'я клієнта</label>
                <input id="user_name" name="user_name" class="form-control" value="{{ $booking->user_name }}" required>
            </div>
            <div class="form-group">
                <label for="user_contact">Контакти клієнта</label>
                <input id="user_contact" name="user_contact" class="form-control" value="{{ $booking->user_contact }}" required>
            </div>
            <div class="form-group">
                <label for="check_in_date">Дата заїзду</label>
                <input type="date" id="check_in_date" name="check_in_date" class="form-control" value="{{ $booking->check_in_date }}" required>
            </div>
            <div class="form-group">
                <label for="check_out_date">Дата виїзду</label>
                <input type="date" id="check_out_date" name="check_out_date" class="form-control" value="{{ $booking->check_out_date }}" required>
            </div>
            <div class="form-group">
                <label for="guests">Кількість гостей</label>
                <input type="number" id="guests" name="guests" class="form-control" value="{{ $booking->guests }}" min="1" max="10" required>
            </div>
            <div class="form-group">
                <label for="payment_method_id">Тип оплати</label>
                <select class="form-control" id="payment_method_id" name="payment_method_id">
                    @foreach($payment_methods as $payment_method)
                        <option value="{{$payment_method->id}}" {{$payment_method->id == $booking->payment_method_id ? 'selected' : ''}}>{{$payment_method->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="payment_confirm">Статус оплати</label>
                <select class="form-control" id="payment_confirm" name="payment_confirm">
                        <option value="{{$booking->payment_confirm}}" {{$booking->payment_confirm == 1 ? 'selected' : ''}}>Оплачено</option>
                        <option value="{{$payment_method->id}}" {{$booking->payment_confirm == 0 ? 'selected' : ''}}>Не оплачено</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Оновити бронювання</button>
        </form>
    </div>
@endsection
