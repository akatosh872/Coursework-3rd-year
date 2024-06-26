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
        <h1>Редагувати номер</h1>

        <form action="{{ route('admin.hotel.rooms.update', [$room->hotel_id, $room->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="photo">Фотографії номеру</label>
                <div class="row">
                    @if ($room->photos)
                        @foreach($room->photos as $photo)
                            <div class="col-md-3 mb-3 position-relative">
                                <img src="{{ asset($photo->path) }}" alt="Фото готелю" class="img-thumbnail">
                                <button class="btn btn-danger delete-photo position-absolute top-0 end-0" style="right: 22px; top: 7px;" data-id="{{ $photo->id }}">X</button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <input type="file" class="" name="photos[]" multiple>
            <div class="form-group">
                <label for="number">Номер</label>
                <input type="number" class="form-control" id="number" name="number" value="{{ $room->number }}" required>
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
                <input type="number" class="form-control" id="beds" name="beds" value="{{$room->beds}}" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="square_meters">Квадратні метри</label>
                <input type="number" class="form-control" id="square_meters" name="square_meters" value="{{$room->square_meters}}" min="0" required>
            </div>
            <div class="form-group">
                <label for="price_per_night">Ціна за ніч</label>
                <input type="number" class="form-control" id="price_per_night" name="price_per_night" value="{{$room->price_per_night}}" min="0" required>
            </div>
            <div class="form-group">
                <label for="amenities">Зручності</label>
                @foreach($amenities as $amenity)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="amenity{{ $amenity->id }}" name="amenities[]" value="{{ $amenity->id }}" {{ in_array($amenity->id, $room->amenities->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="amenity{{ $amenity->id }}">
                            {!! $amenity->amenity !!}
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Підтвердити</button>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-photo').click(function(e) {
                e.preventDefault();

                var photoId = $(this).data('id');

                $.ajax({
                    url: '/admin/hotel/rooms/{{ $room->id }}/photos/' + photoId + '/delete',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        alert('Фото видалено!');
                        location.reload();
                    },
                    error: function() {
                        alert('Помилка при видаленні фото!');
                    }
                });
            });
        });

    </script>
@endsection
