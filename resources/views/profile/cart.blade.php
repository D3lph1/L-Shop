{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')


@section('title')
    @lang('content.profile.cart.title')
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-shopping-cart fa-lg fa-left-big"></i>@lang('content.profile.cart.title')</h1>
        </div>
        <div class="product-container">
            <div class="alert alert-info text-center">
                @lang('content.profile.cart.description')
            </div>
            <div class="text-right">
                <div class="btn-group mb-1 mr-5">
                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('content.all.server')</button>

                    <div class="dropdown-menu">
                        <a href="{{ route('profile.cart', ['server' => $currentServer->id]) }}" class="dropdown-item">@lang('content.profile.cart.any')</a>
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
                            <th>@lang('content.profile.cart.table.image')</th>
                            <th>@lang('content.profile.cart.table.item')</th>
                            <th>@lang('content.profile.cart.table.count')</th>
                            <th>@lang('content.all.server')</th>
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
                    <h3>@lang('content.profile.cart.empty')</h3>
                </div>
            @endif
        </div>
    </div>
@endsection
