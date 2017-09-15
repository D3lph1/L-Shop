{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
<div class="c-product z-depth-1">
    <div class="c-1-info">
        <p class="c-p-name" data-id="{{ $product->getId() }}">{{ $product->getItem()->getName() }}</p>

        <img src="{{ \App\Services\Image::getOrDefault('items/' . $product->getItem()->getImage(), 'empty.png') }}" alt="{{ $product->getItem()->getName() }}" class="product-image image-fluid">

        <button class="btn danger-color btn-sm btn-block cart-remove" data-url="{{ route('cart.remove', ['server' => $currentServer->getId(), 'product' => $product->getId()]) }}">
            <i class="fa fa-times fa-left"></i>
            @lang('content.shop.cart.item.remove')
        </button>

    </div>
    <div class="c-2-info">
        @if($product->getStack() !== 0)
            <p class="c-p-count">@if($product->getItem()->getType() == 'item') @lang('content.shop.cart.item.count') @elseif($product->getItem()->getType() == 'permgroup') @lang('content.shop.cart.item.duration') @endif</p>
            <div class="md-form">
                <input type="text" class="form-control text-center c-p-count-input" value="@if($product->getItem()->getType() == 'permgroup') {{ $product->getStack() }} @else {{ $product->getStack() }} @endif">
            </div>

            <div class="c-p-cbuttons" data-stack="{{ $product->getStack() }}" data-price="{{ $product->getPrice() }}">
                <button class="btn btn-warning btn-sm cart-minus-btn"><i class="fa fa-minus"></i></button>
                <button class="btn btn-warning btn-sm cart-plus-btn"><i class="fa fa-plus"></i></button>
            </div>
        @else
            <div class="alert alert-info alerts">
                @lang('content.shop.cart.item.forever')
            </div>
        @endif

        <p class="c-p-pay">@lang('content.shop.cart.item.total')</p>
        <p class="c-p-pay-money"><span>{{ $product->getPrice() }}</span> {!! s_get('shop.currency_html', 'руб.') !!}</p>

    </div>
</div>
