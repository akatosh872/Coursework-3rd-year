{{-- hotels.blade.php --}}
@extends('layout')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Головна</a></li>
                <li class="breadcrumb-item active" aria-current="page">Пошук готелів</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-4">
                <form action="{{ route('hotels.search') }}" method="GET" class="p-3 mb-2 bg-light text-dark">
                    <div class="form-group">
                        <label for="query">Пошук готелів за назвою або місцем</label>
                        <input type="text" id="query" name="query" class="form-control" placeholder="Пошук готелів" maxlength="100" value="{{ request('query') }}">
                    </div>
                    <div class="form-group">
                        <label for="stars">Кількість зірок</label>
                        <div id="stars" class="star-rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="stars" value="{{ $i }}" {{ request('stars') == $i ? 'checked' : '' }}/>
                                <label for="star{{ $i }}" title="{{ $i }} зірок"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Пошук</button>
                </form>
            </div>
            <div class="col-md-8">
                @foreach($hotels as $hotel)
                    <div class="card mb-3">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <a href="{{route('hotel.show', $hotel->id)}}">
                                    <img src="{{ asset($hotel->photo) }}" alt="{{ $hotel->name }}" class="card-img img-thumbnail hotel-image">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <a href="{{route('hotel.show', $hotel->id)}}">
                                        <h5 class="card-title">{{ $hotel->name }}</h5>
                                    </a>
                                    <p class="card-text">{{ $hotel->description }}</p>
                                    <p class="card-text"><small class="text-muted">{{ $hotel->location }}</small></p>
                                    <p class="card-text">
                                        @for ($i = 0; $i < $hotel->stars; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
