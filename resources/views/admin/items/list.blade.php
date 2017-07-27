{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.items.list.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-diamond fa-lg fa-left-big"></i>@lang('content.admin.items.list.title')</h1>
        </div>
        <div class="mb-1">
            <a href="{{ route('admin.items.add', ['server' => $currentServer->id]) }}" class="btn btn-info btn-block">@lang('content.admin.items.list.add')</a>
        </div>
        <div class="product-container">
            @if($items->count())
                <div class="text-right">
                    <div class="btn-group mb-1 mr-5">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('content.admin.products.list.sort.title')</button>

                        <div class="dropdown-menu">
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id]) }}" class="dropdown-item">@lang('content.admin.products.list.sort.without')</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id, 'orderBy' => 'id', 'orderType' => 'asc']) }}" class="dropdown-item">@lang('content.admin.products.list.sort.id')</a>
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id, 'orderBy' => 'id', 'orderType' => 'desc']) }}" class="dropdown-item">@lang('content.admin.products.list.sort.id_desc')</a>
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id, 'orderBy' => 'name', 'orderType' => 'asc']) }}" class="dropdown-item">@lang('content.admin.products.list.sort.name')</a>
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id, 'orderBy' => 'name', 'orderType' => 'desc']) }}" class="dropdown-item">@lang('content.admin.products.list.sort.name_desc')</a>
                        </div>
                    </div>

                    <div class="btn-group mb-1 mr-5">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('content.admin.products.list.filter.title')</button>

                        <div class="dropdown-menu dropdown-overflow">
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id]) }}" class="dropdown-item">@lang('content.admin.products.list.filter.without')</a>
                            <div class="dropdown-divider"></div>
                            @foreach($filters as $filter)
                                <a href="{{ route('admin.items.list', ['server' => $currentServer->id, 'filter' => $filter]) }}" class="dropdown-item">{{ $filter }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('content.admin.items.list.table.id')</th>
                            <th>@lang('content.admin.items.list.table.image')</th>
                            <th>@lang('content.admin.items.list.table.name')</th>
                            <th>@lang('content.admin.items.list.table.type')</th>
                            <th>@lang('content.admin.items.list.table.extra')</th>
                            <th>@lang('content.admin.items.list.table.edit')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <th scope="row">{{ $item->id }}</th>
                                <td><img height="35" width="35" src="@if(is_file(img_path("items/$item->image"))) {{ asset("img/items/{$item->image}") }} @else {{ asset("img/empty.png") }} @endif"></td>
                                <td>{{ $item->name }}</td>
                                <td>@if ($item->type == 'item') @lang('content.admin.items.add.type.item') @elseif($item->type == 'permgroup') @lang('content.admin.items.add.type.perm') @endif</td>
                                <td>@if(is_null($item->extra)) @lang('content.all.no') @else {{ $item->extra }} @endif</td>
                                <td><a href="{{ route('admin.items.edit', ['server' => $currentServer->id, 'item' => $item->id]) }}" class="btn btn-info btn-sm">@lang('content.admin.items.list.table.edit')</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $items->links('components.pagination') }}
            @else
                <div class="alert alert-info text-center">
                    @lang('content.admin.items.list.empty')
                </div>
            @endif
        </div>
    </div>
@endsection
