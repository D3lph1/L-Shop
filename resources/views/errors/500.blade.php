@extends('layouts.auth')

@section('title')
    500 | Внутренняя ошибка сервера
@endsection

@section('content')
    <div class="text-center mt-6">
        <div class="alert alert-danger">
            <h1>Упс... Кажется, что-то пошло не так.</h1>
        </div>
    </div>
@endsection
