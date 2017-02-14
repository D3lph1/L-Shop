@extends('layouts.shop')

@section('title')
    Корзина
@endsection

@section('content')
    <div id="block-header" class="z-depth-1">
        <h1><i class="fa fa-credit-card fa-left-big"></i>Выберите способ оплаты</h1>
    </div>
    <div id="content-container" class="flex-center flex">
        @if($robokassa)
            <a href="{{ $robokassa }}" class="btn btn-dark-green btn-lg">ROBOKASSA</a>
        @else
            <h3>Нет ни одного доступного способа оплаты</h3>
        @endif
    </div>
@endsection
