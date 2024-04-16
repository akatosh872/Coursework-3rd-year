{{-- create-hotel.blade.php --}}
@extends('admin.layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Додати Новий Готель
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.hotel.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Назва Готелю</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="photo">Фотографія Готелю</label>
                                <input type="file" class="form-control-file" id="photo" name="photo">
                            </div>
                            <div class="form-group">
                                <label for="description">Опис</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="location">Місцезнаходження</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            <div class="form-group">
                                <label for="stars">Кількість Зірок</label>
                                <select class="form-control" id="stars" name="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Створити</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
