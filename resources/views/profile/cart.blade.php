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
            <div class="text-right">
                <div class="btn-group mb-1 mr-5">
                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Сервер</button>

                    <div class="dropdown-menu">
                        <a href="{{ route('profile.cart', ['server' => $currentServer->id]) }}" class="dropdown-item">Любой</a>
                        <div class="dropdown-divider"></div>
                    @foreach($servers as $server)
                            <a href="{{ route('profile.cart', ['server' => $currentServer->id, 'filter_server' => $server->id]) }}" class="dropdown-item">{{ $server->name }}</a>
                        @endforeach
                    </div>
                </div>
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
