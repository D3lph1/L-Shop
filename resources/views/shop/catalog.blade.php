{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.shop.catalog.title')
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
                <a href="{{ route('catalog', ['server' => $currentServer->getId(), 'category' => $category->getId()]) }}"
                   @if($category->getId() == $currentCategory->getId())
                        style="background-color: #FF8800"
                   @endif
                   class="cat-btn waves-effect z-depth-1">
                    <span>{{ $category->getName() }}</span>
                </a>
            @endforeach
        </div>
        <div id="p-containers">
            <div class="product-container">
                @if($products->count())
                    <div class="m-products">
                        @foreach($products as $product)
                            @include('shop.blocks.catalog_item')
                        @endforeach
                    </div>
                    {{ $products->links('components.pagination') }}
                @else
                    <div class="alert alert-info text-center">
                        @lang('content.shop.catalog.category_empty')
                    </div>
                @endif
            </div>
        </div>
    </div>
    @component('components.modal')
        @slot('id')
            catalog-to-buy-modal
        @endslot
        @slot('title')
            @lang('content.shop.catalog.fast_buy_modal.title') (<span id="catalog-to-buy-name"></span>)
        @endslot
        @slot('buttons')
            <button type="button" class="btn btn-warning" id="catalog-to-buy-accept">@lang('content.shop.catalog.fast_buy_modal.next_btn')</button>
            <button type="button" class="btn btn-outline-warning" data-dismiss="modal">@lang('content.shop.catalog.fast_buy_modal.cancel_btn')</button>
        @endslot
        <div class="md-form">
            @if(!$isAuth)
                <input type="text" class="form-control text-center" id="catalog-to-buy-username" placeholder="@lang('content.shop.catalog.fast_buy_modal.username')">
            @endif
            <input type="text" class="form-control text-center" id="catalog-to-buy-count-input">

            <div class="text-center" id="catalog-to-buy-cbuttons">
                <button class="btn btn-warning btn-sm" id="catalog-to-buy-minus-btn"><i class="fa fa-minus"></i></button>
                <button class="btn btn-warning btn-sm" id="catalog-to-buy-plus-btn"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <div class="alert alert-info">
            @if($isAuth)
                @lang('content.shop.catalog.fast_buy_modal.auth', ['span' => '<span id="catalog-to-buy-summ"></span>', 'currency' => $currency])
            @else
                @lang('content.shop.catalog.fast_buy_modal.guest', ['span' => '<span id="catalog-to-buy-summ">', 'currency' => $currency])
            @endif
        </div>
        {!! \ReCaptcha::render() !!}
    @endcomponent
@endsection
