@extends('layout')

@section('content')
    <div class="container">
        <form action="{{ route('hotels.search') }}" method="GET" class="p-3 mb-2 bg-light text-dark">
    <div class="form-group">
        <label for="query">Пошук готелів за назвою або місцем</label>
        <input type="text" id="query" name="query" class="form-control" placeholder="Пошук готелів" maxlength="100" value="{{ request('query') }}">
    </div>
    <div class="form-group">
        <label for="stars">Кількість зірок</label>
        <select id="stars" name="stars" class="form-control">
            <option value="">Всі</option>
            <option value="1" {{ request('stars') == 1 ? 'selected' : '' }}>1 зірка</option>
            <option value="2" {{ request('stars') == 2 ? 'selected' : '' }}>2 зірки</option>
            <option value="3" {{ request('stars') == 3 ? 'selected' : '' }}>3 зірки</option>
            <option value="4" {{ request('stars') == 4 ? 'selected' : '' }}>4 зірки</option>
            <option value="5" {{ request('stars') == 5 ? 'selected' : '' }}>5 зірок</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Пошук</button>
</form>


    @foreach($hotels as $hotel)
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <a href="{{ route('hotel.show', $hotel->id) }}">
                        <img src="{{ asset($hotel->photo) }}" alt="{{ $hotel->name }}" class="card-img img-thumbnail hotel-image">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $hotel->name }}</h5>
                            <p class="card-text">{{ $hotel->description }}</p>
                            <p class="card-text"><small class="text-muted">{{ $hotel->location }}</small></p>
                            <p class="card-text">{{ $hotel->stars }} зірок</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
