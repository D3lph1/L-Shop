<div class="product-block z-depth-1">
    <p class="product-name full-w">{{ $product->name }}</p>
    @if(is_file('img/items/' . $product->image) && file_exists('img/items/' . $product->image))
        <img src="{{ asset('img/items/' . $product->image) }}" alt="prod" class="product-image image-fluid">
    @else
        <img src="{{ asset('img/empty.png') }}" alt="prod" class="product-image image-fluid">
    @endif

    <p class="product-price"><span class="catalog-price-span">{{ $product->price }}</span> {!! s_get('shop.currency_html', 'руб.') !!}</p>
    <p class="product-count">за <span>{{ $product->stack }}</span> шт.</p>

    @if($cart->has($product->id))
        <button class="btn btn-info btn-block btn-sm catalog-to-cart disabled" disabled="disabled" data-url="{{ route('cart.put', ['server' => $currentServer->id, 'product' => $product->id ]) }}">
            <i class="fa fa-cart-arrow-down fa-left"></i>
            <span>
                Уже в корзине
            </span>
        </button>
    @else
        <button class="btn btn-info btn-block btn-sm catalog-to-cart"
                data-url="{{ route('cart.put', ['server' => $currentServer->id, 'product' => $product->id ]) }}">
            <i class="fa fa-cart-arrow-down fa-left"></i>
            <span>
                В корзину
            </span>
        </button>
    @endif

    <button class="btn btn-warning btn-block btn-sm catalog-to-buy"
                data-url="{{ route('catalog.buy', ['server' => $currentServer, 'product' => $product->id]) }}">
        <i class="fa fa-money fa-left"></i>
        Быстрая покупка
    </button>
</div>
