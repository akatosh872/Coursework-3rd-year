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
        @foreach($hotels as $hotel)
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <a href="{{route("admin.hotel.show", $hotel->id)}}">
                            <img src="{{ asset($hotel->photo) }}" alt="{{ $hotel->name }}"
                                 class="card-img img-thumbnail hotel-image">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <a href="{{route("admin.hotel.show", $hotel->id)}}"><h5
                                    class="card-title">{{ $hotel->name }}</h5></a>
                            <p class="card-text">{{ $hotel->description }}</p>
                            <p class="card-text"><small class="text-muted">{{ $hotel->location }}</small></p>
                            <p class="card-text">{{ $hotel->stars }} зірок</p>
                            <form action="{{ route('admin.hotel.delete', $hotel->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Видалити</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
