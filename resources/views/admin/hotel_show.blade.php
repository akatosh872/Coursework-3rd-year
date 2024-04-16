@extends('admin.layout')

@section('content')
    <div class="container mt-4">
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
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Перегляд Готелю
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.hotel.update', $hotel->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Назва Готелю</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $hotel->name }}"
                                       required>
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
                                <textarea class="form-control" id="description" name="description"
                                          rows="3">{{ $hotel->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="location">Місцезнаходження</label>
                                <input type="text" class="form-control" id="location" name="location"
                                       value="{{ $hotel->location }}" required>
                            </div>
                            <div class="form-group">
                                <label for="stars">Кількість Зірок</label>
                                <select class="form-control" id="stars" name="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option
                                            value="{{ $i }}" {{ $hotel->stars == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Оновити</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Відображення існуючих номерів готелю -->
                <div class="card">
                    @if($hotel->rooms->isEmpty())
                        <p>Немає номерів для цього готелю.</p>
                    @else
                        @foreach($hotel->rooms as $room)
                            <div class="card mt-4">
                                <div class="card-header">
                                    <a href="{{route('admin.hotel.rooms.show', [$room->hotel_id, $room->id])}}">
                                    Номер {{ $room->number }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div id="createRoomModal" class="card" style="display: none;">
                    <div class="card-header">
                        Створити номер
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.hotel.rooms.create', $hotel->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="number">Номер</label>
                                <input type="number" class="form-control" id="number" name="number" required>
                            </div>
                            <div class="form-group">
                                <label for="type_id">Тип номеру</label>
                                <select class="form-control" id="type_id" name="type_id">
                                    @foreach($roomTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="beds">Кількість ліжок</label>
                                <input type="number" class="form-control" id="beds" name="beds" min="1" max="5"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>Зручності</label>
                                @foreach($amenities as $amenity)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="amenity{{ $amenity->id }}"
                                               name="amenities[]" value="{{ $amenity->id }}">
                                        <label class="form-check-label" for="amenity{{ $amenity->id }}">
                                            {{ $amenity->amenity }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="square_meters">Квадратні метри</label>
                                <input type="number" class="form-control" id="square_meters" name="square_meters"
                                       min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="price_per_night">Ціна за ніч</label>
                                <input type="number" class="form-control" id="price_per_night" name="price_per_night"
                                       min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="photo1">Фотографія номеру 1</label>
                                <input type="file" class="form-control-file" id="photo1" name="photo1">
                            </div>
                            <div class="form-group">
                                <label for="photo2">Фотографія номеру 2</label>
                                <input type="file" class="form-control-file" id="photo2" name="photo2">
                            </div>
                            <div class="form-group">
                                <label for="photo3">Фотографія номеру 3</label>
                                <input type="file" class="form-control-file" id="photo3" name="photo3">
                            </div>
                            <button type="submit" class="btn btn-primary">Створити</button>
                        </form>
                    </div>
                </div>

                <button id="createRoomButton" class="btn btn-primary">Створити номер</button>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#createRoomButton").click(function () {
                $("#createRoomModal").show();
            });
        });
        $(document).mouseup(function (e) {
            var container = $("#createRoomModal");

            // якщо клік був поза контейнером, зробити його невидимим
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide();
            }
        });
    </script>
@endsection
