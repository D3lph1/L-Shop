@extends('layouts.shop')


@section('title')
    Внутриигровая корзина
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-shopping-cart fa-lg fa-left-big"></i>Внутриигровая корзина</h1>
        </div>
        <div class="product-container">
            <div class="alert alert-info">
                На этой странице вы можете просмотреть все товары, которые вы приобрели, но еще не забрали в игре.
            </div>
            @if($items->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Изображение</th>
                            <th>Предмет</th>
                            <th>Количество</th>
                            <th>Сервер</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td><img height="35" width="35" src="@if(is_file(img_path("items/$item->image"))) {{ asset("img/items/{$item->image}") }} @else {{ asset("img/empty.png") }} @endif"></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->amount }}</td>
                                @foreach($servers as $server)
                                    @if($server->id == $item->server)
                                        <td>{{ $server->name }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $items->links('components.pagination') }}
            @else
                <div class="text-center">
                    <h3>История платежей пуста</h3>
                </div>
            @endif
        </div>
    </div>
@endsection
