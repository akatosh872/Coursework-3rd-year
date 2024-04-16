@extends('layout')

@section('content')
    <style>
        .room-image {
            width: 100%;
            max-width: 300px;
            height: auto;
        }
    </style>
    <div class="container">
        <h1>Номер {{ $room->number }}</h1>
        <p><strong>{{ $room->beds }} ліжок</strong></p>
        <p><strong>{{ $room->square_meters }} квадратних метрів</strong></p>
        <p><strong>{{ $room->price_per_night }} за ніч</strong></p>
        <div class="amenities">
            @foreach($room->amenities as $amenity)
                <span>{{ $amenity->amenity }}</span>
            @endforeach
        </div>
        <div class="room-images">
            @foreach($room->photos as $photo)
                <a href="{{ asset($photo->path) }}" data-fancybox="room{{ $room->id }}">
                    <img src="{{ asset($photo->path) }}" alt="Photo of room {{ $room->number }}"
                         class="img-thumbnail room-image">
                </a>
            @endforeach
        </div>
        <!-- Місце для форми бронювання -->
    </div>
@endsection
