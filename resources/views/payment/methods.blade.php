{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Выбор способа оплаты
@endsection

@section('content')
    <div id="block-header" class="z-depth-1">
        <h1><i class="fa fa-credit-card fa-left-big"></i>Выберите способ оплаты</h1>
    </div>
    <div id="content-container" class="flex-first flex">
        @if($robokassa)
            <a href="{{ $robokassa }}" class="btn btn-warning btn-lg btn-block">ROBOKASSA</a>
        @else
            <div class="flex-center flex">
                <h3>Нет ни одного доступного способа оплаты</h3>
            </div>
        @endif
    </div>
@endsection
