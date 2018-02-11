@extends('layout.shop')

@section('title')
    @lang('content.shop.catalog.title')
@endsection

@section('content')
    <div id="logo-block">
        <div class="logo-img">
            <img src="{{ asset('img/layout/logo/small.png') }}" alt="logo" class="c-logo">
        </div>
        <div class="logo-text text-depth">
            <h1>{{ $shopName }}</h1>
        </div>
    </div>
    <div id="categories" class="col-12">
        @foreach($server->getCategories() as $category)
            <a href="{{ route('frontend.catalog.render', ['server' => $server->getId(), 'category' => $category->getId()]) }}"
               @if($category->getId() === $currentCategory->getId())
                    style="background-color: #FF8800"
               @endif
               class="cat-btn waves-effect z-depth-1">
                <span>{{ $category->getName() }}</span>
            </a>
        @endforeach
    </div>
    <div id="p-containers">
        <div class="product-container">
            @if($products !== null)
                @if($products->count())
                    <div class="m-products">
                        @foreach($products as $product)
                            <catalog-item
                                    :product-id="{{ $product->getId() }}"
                                    name="{{ $product->getItem()->getName() }}"
                                    image="{{ \App\Services\Media\Image::itemImagePath($product->getItem()->getImage()) }}"
                                    :price="{{ json_encode($product->getPrice()) }}"
                                    currency="{{ $currency }}"
                                    :stack="{{ json_encode($product->getStack()) }}"
                                    is-item="{{ $product->getItem()->getType() === \App\Services\Item\Type::ITEM }}"
                                    is-permgroup="{{ $product->getItem()->getType() === \App\Services\Item\Type::PERMGROUP }}"
                                    :in-cart="{{ json_encode($cart->exist(new \App\Services\Cart\Item($product, 0))) }}"
                                    put-in-cart-route="{{ route('frontend.cart.put') }}"
                                    quick-purchase-route="{{ '' }}"
                            ></catalog-item>
                        @endforeach
                    </div>
                    {{ $products->links('components.pagination') }}
                @else
                    <div class="alert alert-info text-center">
                        @lang('content.shop.catalog.category_empty')
                    </div>
                @endif
            @else
                <div class="alert alert-info text-center">
                    @lang('content.shop.catalog.categories_does_not_exist')
                </div>
            @endif
        </div>
    </div>
    <quick-purchase-modal
            currency="{{ $currency }}"
            captcha="{{ $captcha }}"
    ></quick-purchase-modal>
@endsection
