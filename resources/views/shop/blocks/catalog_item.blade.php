<div class="product-block z-depth-1">
    <p class="product-name full-w">{{ $product->name }}</p>
    @if(is_file('img/items/' . $product->image) && file_exists('img/items/' . $product->image))
        <img src="/img/items/{{ $product->image }}" alt="prod" class="product-image image-fluid">
    @else
        <img src="/img/empty.png" alt="prod" class="product-image image-fluid">
    @endif
    <p class="product-price"><span>{{ $product->price }}</span><i class="fa fa-dollar fa-right"></i></p>
    <p class="product-count">за <span>{{ $product->stack }}</span> шт.</p>
    @if($cart->has($currentServer->id, $product->id))
        <button class="btn btn-info btn-block btn-sm catalog-to-cart disabled" disabled="disabled"
                data-url="{{ route('cart.put', ['server' => $currentServer->id, 'product' => $product->id ]) }}">
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
    <button class="btn btn-warning btn-block btn-sm catalog-to-buy">
        <i class="fa fa-money fa-left"></i>
        Быстрая покупка
    </button>
</div>