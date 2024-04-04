{{-- show-hotel.blade.php --}}
@extends('admin.layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Перегляд Готелю
                    </div>
                    <div class="card-body">
                        <form action="{{ route('hotel.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Назва Готелю</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $hotel->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="photo">Фотографія Готелю</label>
                                @if ($hotel->photo)
                                    <div class="mb-3">
                                        <img src="{{ asset($hotel->photo) }}" alt="Фото готелю" class="img-thumbnail">
                                    </div>
                                @endif
                                <input type="file" class="form-control-file" id="photo" name="photo">
                            </div>
                            <div class="form-group">
                                <label for="description">Опис</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $hotel->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="location">Місцезнаходження</label>
                                <input type="text" class="form-control" id="location" name="location" value="{{ $hotel->location }}" required>
                            </div>
                            <div class="form-group">
                                <label for="stars">Кількість Зірок</label>
                                <select class="form-control" id="stars" name="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ $hotel->stars == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price">Ціна за ніч</label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ $hotel->price }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Оновити</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
