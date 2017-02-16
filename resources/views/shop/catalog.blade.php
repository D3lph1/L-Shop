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
@endsection
