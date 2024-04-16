@extends('admin.layout')

@section('content')
    <div class="container mt-5">
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
        <div class="jumbotron">
            <h1 class="display-4">Вітаємо в Адмін Панелі!</h1>
            <p class="lead">Це проста вітальна сторінка для адмінки вашого сайту.</p>
            <hr class="my-4">
            <p>Використовуйте навігацію, щоб перейти до різних розділів адмінки.</p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Дізнатися більше</a>
        </div>
    </div>
@endsection