@extends('layouts.shop')

@section('title')
    Каталог товаров
@endsection

@section('content')
    <div id="content-container">
        <div id="logo-block">
            <div class="logo-img">
                <img src="/img/logo_small.png" alt="logo" class="c-logo">
            </div>
            <div class="logo-text text-depth">
                <h1>{{ $shopName }}</h1>
            </div>
        </div>
        <div id="categories" class="col-12">
            @foreach($categories as $category)
                <div id="{{ $loop->iteration }}-cat" class="cat-btn waves-effect z-depth-1">
                    <span>{{ $category->name }}</span>
                </div>
            @endforeach
        </div>
        <div id="p-containers">
            @foreach($categories as $category)
                <div class="product-container" id="{{ $loop->iteration }}-con">
                    @foreach($goods as $good)
                        @if ($good->category_id == $category->id)
                            @include('shop.blocks.catalog_item')
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
