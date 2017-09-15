{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.products.list.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-cubes fa-lg fa-left-big"></i>@lang('content.admin.products.list.title')</h1>
        </div>
        <div class="mb-1">
            <a href="{{ route('admin.products.add', ['server' => $currentServer->getId()]) }}" class="btn btn-info btn-block">@lang('content.admin.products.list.add')</a>
        </div>
        <div class="product-container">
            @if($products->count())
                <div class="text-right">
                    <div class="btn-group mb-1 mr-5">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('content.admin.products.list.sort.title')</button>

                        <div class="dropdown-menu">
                            <a href="{{ route('admin.products.list', ['server' => $currentServer->getId()]) }}" class="dropdown-item">@lang('content.admin.products.list.sort.without')</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.products.list', ['server' => $currentServer->getId(), 'orderBy' => 'products.id', 'orderType' => 'asc']) }}" class="dropdown-item">@lang('content.admin.products.list.sort.id')</a>
                            <a href="{{ route('admin.products.list', ['server' => $currentServer->getId(), 'orderBy' => 'products.id', 'orderType' => 'desc']) }}" class="dropdown-item">@lang('content.admin.products.list.sort.id_desc')</a>
                            <a href="{{ route('admin.products.list', ['server' => $currentServer->getId(), 'orderBy' => 'items.name', 'orderType' => 'asc']) }}" class="dropdown-item">@lang('content.admin.products.list.sort.name')</a>
                            <a href="{{ route('admin.products.list', ['server' => $currentServer->getId(), 'orderBy' => 'items.name', 'orderType' => 'desc']) }}" class="dropdown-item">@lang('content.admin.products.list.sort.name_desc')</a>
                        </div>
                    </div>

                    <div class="btn-group mb-1 mr-5">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('content.admin.products.list.filter.title')</button>

                        <div class="dropdown-menu dropdown-overflow">
                            <a href="{{ route('admin.products.list', ['server' => $currentServer->getId()]) }}" class="dropdown-item">@lang('content.admin.products.list.filter.without')</a>
                            <div class="dropdown-divider"></div>
                            @foreach($filters as $filter)
                                <a href="{{ route('admin.products.list', ['server' => $currentServer->getId(), 'filter' => $filter]) }}" class="dropdown-item">{{ $filter }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('content.admin.products.list.table.id')</th>
                            <th>@lang('content.admin.products.list.table.image')</th>
                            <th>@lang('content.admin.products.list.table.name')</th>
                            <th>@lang('content.admin.products.list.table.price')</th>
                            <th>@lang('content.admin.products.list.table.count')</th>
                            <th>@lang('content.admin.products.list.table.server')</th>
                            <th>@lang('content.admin.products.list.table.category')</th>
                            <th>@lang('content.admin.products.list.table.edit')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <th scope="row">{{ $product->getId() }}</th>
                                <td><img height="35" width="35" src=" {{ \App\Services\Image::getOrDefault('items/' . $product->getItem()->getImage(), 'empty.png') }}"></td>
                                <td>{{ $product->getItem()->getName() }}</td>
                                <td>{{ $product->getPrice() }}</td>
                                <td>{{ $product->getStack() }}</td>
                                <td>{{ $product->getCategory()->getServer()->getName() }}</td>
                                <td>{{ $product->getCategory()->getName() }}</td>
                                <td><a href="{{ route('admin.products.edit', ['server' => $currentServer->getId(), 'product' => $product->getId()]) }}" class="btn btn-info btn-sm">Редактировать</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $products->links('components.pagination') }}
            @else
                <div class="alert alert-info text-center">
                    @lang('content.admin.products.list.empty')
                </div>
            @endif
        </div>
    </div>
@endsection
