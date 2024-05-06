@extends('admin.layout')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <h1>Відгуки</h1>
        @foreach($reviews as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <a href="{{route('room.show', $review->room->id)}}">
                    <h5 class="card-title">{{ $review->user->name }}</h5>
                    </a>
                    <p class="card-text">{{ $review->review }}</p>
                    <p class="card-text"><small class="text-muted">{{ $review->rating }} зірок</small></p>
                    @if($review->response)
                        <p class="card-text"><strong>Відповідь адміністратора:</strong> {{ $review->response }}</p>
                    @endif
                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Видалити відгук</button>
                    </form>
                    <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="response">Відповідь</label>
                            <textarea id="response" name="response" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Зберегти відповідь</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
