@extends('layout.shop')

@section('title')
    @lang('content.shop.cart.title')
@endsection

@section('content')
    <cart
            is-auth="{{ $isAuth }}"
            currency="{{ $currency }}"
            :cart="{{ json_encode($cart) }}"
            captcha="{{ $captcha }}"
            route-remove="{{ route('frontend.cart.remove') }}"
    ></cart>
@endsection
