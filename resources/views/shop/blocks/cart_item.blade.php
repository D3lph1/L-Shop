{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
<div class="c-product z-depth-1">
    <div class="c-1-info">
        <p class="c-p-name" data-id="{{ $product->id }}">{{ $product->name }}</p>
        @if(is_file(img_path('items/' . $product->image)) && file_exists(img_path('items/' . $product->image)))
            <img src="{{ asset('img/items/' . $product->image) }}">
        @else
            <img src="{{ asset('img/empty.png') }}">
        @endif

        <button class="btn danger-color btn-sm btn-block cart-remove" data-url="{{ route('cart.remove', ['server' => $currentServer->id, 'product' => $product->id]) }}">
            <i class="fa fa-times fa-left"></i>
            Убрать
        </button>

    </div>
    <div class="c-2-info">
        @if($product->stack !== 0)
            <p class="c-p-count">@if($product->type == 'item') @lang('content.shop.cart.item.count') @elseif($product->type == 'permgroup') @lang('content.shop.cart.item.duration') @endif</p>
            <div class="md-form">
                <input type="text" class="form-control text-center c-p-count-input" value="@if($product->type == 'permgroup') {{ $product->stack }} @else {{ $product->stack }} @endif">
            </div>

            <div class="c-p-cbuttons" data-stack="{{ $product->stack }}" data-price="{{ $product->price }}">
                <button class="btn btn-warning btn-sm cart-minus-btn"><i class="fa fa-minus"></i></button>
                <button class="btn btn-warning btn-sm cart-plus-btn"><i class="fa fa-plus"></i></button>
            </div>
        @else
            <div class="alert alert-info alerts">
                @lang('content.shop.cart.item.forever')
            </div>
        @endif

        <p class="c-p-pay">@lang('content.shop.cart.item.total')</p>
        <p class="c-p-pay-money"><span>{{ $product->price }}</span> {!! s_get('shop.currency_html', 'руб.') !!}</p>

    </div>
</div>
