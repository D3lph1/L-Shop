{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
<div class="product-block z-depth-1">
    <p class="product-name full-w">{{ $product->getItem()->getName() }}</p>

    <img src="{{ \App\Services\Image::getOrDefault('items/' . $product->getItem()->getImage(), 'empty.png') }}" alt="{{ $product->getItem()->getName() }}" class="product-image image-fluid">

    <p class="product-price"><span class="catalog-price-span">{{ $product->getPrice() }}</span> {!! s_get('shop.currency_html', 'руб.') !!}</p>
    <p class="product-count">
        @if(!($product->getItem()->getType() === \App\Services\Items\Type::PERMGROUP and $product->getStack() === 0))
            @lang('content.shop.catalog.item.for')
        @endif
        <span class="number">
            @if($product->getItem()->getType() === \App\Services\Items\Type::ITEM)
                {{ $product->getStack() }}
            @elseif($product->getItem()->getType() === \App\Services\Items\Type::PERMGROUP)
                @if($product->getStack() === 0)
                    @lang('content.shop.catalog.item.forever')
                @else
                    {{ $product->getStack() }}
                @endif
            @endif
        </span>
        @if($product->getItem()->getType() === \App\Services\Items\Type::ITEM)
                @lang('content.shop.catalog.item.items')
        @else
            @if($product->getStack() !== 0)
                @lang('content.shop.catalog.item.duration')
            @endif
        @endif
    </p>

    @if($cart->has($product->getId()))
        <button class="btn btn-info btn-block btn-sm catalog-to-cart disabled" disabled="disabled" data-url="{{ route('cart.put', ['server' => $currentServer->getId(), 'product' => $product->getId() ]) }}">
            <i class="fa fa-cart-arrow-down fa-left"></i>
            <span>
                @lang('content.shop.catalog.item.already_in_cart')
            </span>
        </button>
    @else
        <button class="btn btn-info btn-block btn-sm catalog-to-cart"
                data-url="{{ route('cart.put', ['server' => $currentServer->getId(), 'product' => $product->getId() ]) }}">
            <i class="fa fa-cart-arrow-down fa-left"></i>
            <span>
                @lang('content.shop.catalog.item.put_in_cart')
            </span>
        </button>
    @endif

    <button class="btn btn-warning btn-block btn-sm catalog-to-buy"
                data-url="{{ route('catalog.buy', ['server' => $currentServer->getId(), 'product' => $product->getId()]) }}">
        <i class="fa fa-money fa-left"></i>
        @lang('content.shop.catalog.item.fast_buy')
    </button>
</div>
