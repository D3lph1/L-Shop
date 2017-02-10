<div class="product-block z-depth-1">
    <p class="product-name full-w">{{ $good->name }}</p>
    @if(is_file('img/items/' . $good->image) && file_exists('img/items/' . $good->image))
        <img src="/img/items/{{ $good->image }}" alt="prod" class="product-image image-fluid">
    @else
        <img src="/img/empty.png" alt="prod" class="product-image image-fluid">
    @endif
    <p class="product-price"><span>{{ $good->price }}</span><i class="fa fa-dollar fa-right"></i></p>
    <p class="product-count">за <span>{{ $good->stack }}</span> шт.</p>
    <button class="btn btn-info btn-block btn-sm"><i class="fa fa-shopping-cart fa-left"></i>To
        cart
    </button>
    <button class="btn btn-warning btn-block btn-sm"><i class="fa fa-plus fa-left"></i>Go buy
    </button>
</div>