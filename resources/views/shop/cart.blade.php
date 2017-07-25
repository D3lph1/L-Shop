{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Корзина
@endsection

@section('content')
    <div style="display: none;">
        <div id="cart-empty">@lang('content.shop.cart.empty')</div>
    </div>

    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-shopping-cart fa-lg fa-left-big"></i>Корзина</h1>
        </div>
        @if(!$cart->isEmpty())
            <div id="total">
                <div id="total-p">
                    @if(!is_auth())
                        <div class="md-form inline">
                            <i class="fa fa-user prefix"></i>
                            <input type="text" id="c-login" class="form-control">
                            <label for="c-login">Имя пользователя</label>
                        </div>
                    @endif
                    <div class="inline">
                        Итого:
                        <span id="total-money"><span>{{ $cost }}</span> {!! s_get('shop.currency_html', 'руб.') !!}</span>
                    </div>
                        <div class="mr-2 ml-2">
                            {!! \ReCaptcha::render(true) !!}
                        </div>
                    <button class="btn btn-warning btn-sm" id="btn-cart-go-pay" data-url="{{ route('cart.buy', ['server' => $currentServer->id]) }}">
                        Сформировать и оплатить
                        <i class="fa fa-arrow-right fa-right"></i>
                    </button>
                </div>
            </div>
        @endif
        <div id="cart-products">
            @if(!$cart->isEmpty())
                    @foreach($products as $product)
                        @include('shop.blocks.cart_item')
                    @endforeach
            @else
                <h3>Корзина пуста</h3>
            @endif
        </div>
    </div>
@endsection
