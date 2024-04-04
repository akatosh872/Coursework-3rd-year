@extends('layout')

@section('content')
    <div class="container">
        @foreach($hotels as $hotel)
            <div class="card mb-3">
                <img src="{{ asset($hotel->photo) }}" alt="{{ $hotel->name }}" class="card-img-top img-thumbnail hotel-image">
                <div class="card-body">
                    <h5 class="card-title">{{ $hotel->name }}</h5>
                    <p class="card-text">{{ $hotel->description }}</p>
                    <p class="card-text"><small class="text-muted">{{ $hotel->location }}</small></p>
                    <p class="card-text">{{ $hotel->stars }} зірок</p>
                    <p class="card-text">{{ $hotel->price }} грн</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
