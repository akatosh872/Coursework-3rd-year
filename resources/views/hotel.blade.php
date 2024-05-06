{{-- hotel.blade.php --}}
@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>{{ $hotel->name }}</h1>
                <p>{{ $hotel->description }}</p>
                @if($hotel->photo)
                    <a href="{{ asset($hotel->photo) }}" data-fancybox="hotel">
                        <img src="{{ asset($hotel->photo) }}" alt="Photo of hotel {{ $hotel->name }}"
                             class="img-thumbnail hotel-image" style="width: 100%;">
                    </a>
                @endif
                <p><strong>Розташування:</strong> {{ $hotel->location }}</p>
                <p><strong>Зірки:</strong>
                    @for ($i = 0; $i < $hotel->stars; $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                </p>
            </div>
            <div class="col-md-4">
                <h2>Номери</h2>
                @if(count($rooms) >= 3)
                    <form action="{{ route('hotel.show', $hotel->id) }}" method="GET">
                        <div class="form-group">
                            <label for="sort">Сортувати за:</label>
                            <select id="sort" name="sort" class="form-control">
                                <option value="price_per_night" {{ request('sort') == 'price_per_night' ? 'selected' : '' }}>Ціною</option>
                                <option value="beds" {{ request('sort') == 'beds' ? 'selected' : '' }}>Кількістю ліжок</option>
                                <option value="type_id" {{ request('sort') == 'type_id' ? 'selected' : '' }}>Типом номерів</option>
                                <option value="square_meters" {{ request('sort') == 'square_meters' ? 'selected' : '' }}>Квадратними метрами</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Сортувати</button>
                    </form>
                @endif
                @foreach($rooms as $room)
                    <div class="card mb-3">
                        <div class="card-body">
                            <a href="{{ route('room.show', $room->id) }}">
                            <h5 class="card-title">Номер {{ $room->number }}</h5>
                            </a>
                            <p class="card-text"><i class="fas fa-bed"></i> {{ $room->beds }} ліжок</p>
                            <p class="card-text"><i class="fas fa-ruler-combined"></i> {{ $room->square_meters }} квадратних метрів</p>
                            <p class="card-text"><i class="fas fa-door-open"></i> {{ $room->type->type }} </p>
                            <p class="card-text"><strong><i class="fas fa-money-bill-wave"></i> {{ $room->price_per_night }} за ніч</strong></p>
                            <div class="amenities">
                                @foreach($room->amenities as $amenity)
                                    <span class="badge badge-secondary">{{ $amenity->amenity }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
@endsection
