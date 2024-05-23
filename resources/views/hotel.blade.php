@extends('layout')

@section('content')
    <div class="container">
        <h1>{{ $hotel->name }}</h1>
        <p>{{ $hotel->description }}</p>
        @if($hotel->photo)
            <a href="{{ asset($hotel->photo) }}" data-fancybox="hotel">
                <img src="{{ asset($hotel->photo) }}" alt="Photo of hotel {{ $hotel->name }}"
                     class="img-thumbnail hotel-image" style="width: 100%; max-height: 500px;">
            </a>
        @endif
        <p><strong>Розташування:</strong> {{ $hotel->location }}</p>
        <p><strong>Зірки:</strong>
            @for ($i = 0; $i < $hotel->stars; $i++)
                <i class="fas fa-star"></i>
            @endfor
        </p>

        <h2>Номери</h2>
        <div class="row">
            @foreach($rooms as $room)
                <div class="col-md-4">
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
                </div>
            @endforeach
        </div>
        {{ $rooms->links() }}
    </div>
@endsection
