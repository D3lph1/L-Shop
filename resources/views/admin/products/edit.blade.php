{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.products.edit.title')
@endsection

@section('content')
    @include('components.localization.admin.products')

    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-cube fa-lg fa-left-big"></i>@lang('content.admin.products.edit.title')</h1>
        </div>
        <form method="post" action="{{ route('admin.products.edit.save', ['server' => $currentServer->id, 'item' => $product->id]) }}">
            <div id="s-change-name" class="mt-3">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <h4>@lang('content.admin.products.add.attach_item')</h4>
                            <div class="btn-group mb-2 mt-1">
                                <button id="edit-products-clip" class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">[{{ $product->item_id }}] {{ $product->name }}</button>

                                <div class="dropdown-menu dropdown-overflow">
                                    <a class="dropdown-item edit-products-clip-item change" data-item="{{ $product->item_id }}" data-item-type="{{ $product->type }}" data-parent="edit-products-clip">[{{ $product->item_id }}] {{ $product->name }}</a>
                                    <div class="dropdown-divider"></div>
                                    @foreach($items as $item)
                                        <a class="dropdown-item edit-products-clip-item change" data-item="{{ $item->id }}" data-item-type="{{ $item->type }}" data-parent="edit-products-clip">[{{ $item->id }}] {{ $item->name }}</a>
                                    @endforeach
                                </div>
                                <input type="hidden" name="item" id="item" value="{{ $product->item_id }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="s-settings-cat">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12">
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-cubes prefix"></i>
                                    <input type="text" name="stack" id="stack" class="form-control" value="{{ $product->stack }}">
                                    <label for="stack">@if($product->type == 'permgroup') @lang('content.admin.products.add.perm_duration') @else @lang('content.admin.products.add.products_in_stack') @endif</label>
                                </div>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-money prefix"></i>
                                    <input type="text" name="price" id="price" class="form-control" value="{{ $product->price }}">
                                    <label for="price">@if($product->type == 'permgroup') @lang('content.admin.products.add.perm_price') @else @lang('content.admin.products.add.products_price') @endif</label>
                                </div>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-sort-amount-desc prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="@lang('components.popover.title')" data-html="true" data-content="@lang('content.admin.products.add.sort_priority_popover')"></i>
                                    <input type="text" name="sort_priority" id="admin-product-sort-priority" class="form-control" value="{{ $product->sort_priority }}">
                                    <label for="admin-product-sort-priority">@lang('content.admin.products.add.sort_priority')</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <h4>@lang('content.admin.products.add.attach_server_category')</h4>
                            <div class="btn-group mb-2 mt-1">
                                <button id="edit-categories-clip" class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $serverName }} / {{ $categoryName }}</button>

                                <div class="dropdown-menu dropdown-overflow">
                                    <a class="dropdown-item change" data-parent="edit-categories-clip">{{ $serverName }} / {{ $categoryName }}</a>
                                    <div class="dropdown-divider"></div>
                                    @foreach($categories as $category)
                                        <a class="dropdown-item edit-categories-clip-item change" data-server="{{ $category->server_id }}" data-category="{{ $category->category_id }}" data-parent="edit-categories-clip">{{ $category->server }} / {{ $category->category }}</a>
                                    @endforeach
                                </div>
                                <input type="hidden" name="server" id="server" value="{{ $serverId }}">
                                <input type="hidden" name="category" id="category" value="{{ $categoryId }}">
                            </div>
                        </div>

                        <div class="col-sm-6 offset-sm-3 col-12 save-and-del text-center">
                            {{ csrf_field() }}
                            <button class="btn btn-info"><i class="fa fa-check fa-left"></i>@lang('content.admin.products.add.save')</button>
                            <a href="{{ route('admin.products.edit.remove', ['server' => $currentServer->id, 'product' => $product->id]) }}" class="btn danger-color"><i class="fa fa-times fa-left"></i>@lang('content.admin.products.edit.remove')</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
