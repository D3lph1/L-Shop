@extends('layouts.shop')

@section('title')
    Каталог товаров
@endsection

@section('content')
    <div id="content-container">
        <div id="logo-block">
            <div class="logo-img">
                <img src="{{ asset('img/logo_small.png') }}" alt="logo" class="c-logo">
            </div>
            <div class="logo-text text-depth">
                <h1>{{ $shopName }}</h1>
            </div>
        </div>
        <div id="categories" class="col-12">
            @foreach($categories as $category)
                <a href="{{ route('catalog', ['server' => $currentServer, 'category' => $category->id]) }}"
                   @if($category->id == $currentCategory) style="background-color: #FF8800"
                   @endif class="cat-btn waves-effect z-depth-1">
                    <span>{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
        <div id="p-containers">
            <div class="product-container">
                <div class="m-products">
                    @foreach($goods as $product)
                        @include('shop.blocks.catalog_item')
                    @endforeach
                </div>
                {{ $goods->links('components.pagination') }}
            </div>
        </div>
    </div>
    @component('components.modal')
        @slot('id')
            catalog-to-buy-modal
        @endslot
        @slot('title')
            Быстрая покупка
        @endslot
        @slot('buttons')
            <button type="button" class="btn btn-danger" id="catalog-to-buy-accept">Продолжить</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Отменить</button>
        @endslot
        <div class="md-form">
            @if(!$isAuth)
                <input type="text" class="form-control text-center" id="catalog-to-buy-username" placeholder="Имя пользователя">
            @endif
            <input type="text" class="form-control text-center" id="catalog-to-buy-count-input">

            <div class="text-center" id="catalog-to-buy-cbuttons">
                <button class="btn btn-warning btn-sm" id="catalog-to-buy-minus-btn"><i class="fa fa-minus"></i></button>
                <button class="btn btn-warning btn-sm" id="catalog-to-buy-plus-btn"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <div class="alert alert-info">
            @if($isAuth)
                С вашего счёта будет списана сумма в размере <span id="catalog-to-buy-summ"></span> {!! $currency !!}
                Если же средств недостаточно, вы будете автоматически перенаправлены на страницу оплаты.
            @else
                Вы будете перенаправлены на страницу выбора способа оплаты. Сумма заказа:
                <span id="catalog-to-buy-summ"></span> {!! $currency !!}
            @endif
        </div>


    @endcomponent
@endsection
