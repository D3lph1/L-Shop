{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.auth')

@section('title')
    403 | Запрещено
@endsection

@section('content')
    <div class="text-center mt-6">
        <div class="alert alert-danger">
            <h1>Запрещено</h1>
        </div>
        <a href="{{ route('index') }}" class="btn danger-color">На главную</a>
    </div>
@endsection
