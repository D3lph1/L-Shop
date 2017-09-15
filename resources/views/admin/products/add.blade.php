{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.products.add.title')
@endsection

@section('content')
    @include('components.localization.admin.products')

    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-cube fa-lg fa-left-big"></i>@lang('content.admin.products.add.title')</h1>
        </div>
        <form method="post" action="{{ route('admin.products.add.save', ['server' => $currentServer->getId()]) }}">
            <div id="s-change-name" class="mt-3">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <h4>@lang('content.admin.products.add.attach_item')</h4>
                            <div class="btn-group mb-2 mt-1">
                                <button id="edit-products-clip" class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('content.all.select')</button>

                                <div class="dropdown-menu dropdown-overflow">
                                    @foreach($items as $item)
                                        <a class="dropdown-item edit-products-clip-item change" data-item="{{ $item->getId() }}" data-item-type="{{ $item->getType() }}" data-parent="edit-products-clip">[{{ $item->getId() }}] {{ $item->getName() }}</a>
                                    @endforeach
                                </div>
                                <input type="hidden" name="item" id="item">
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
                                    <input type="text" name="stack" id="stack" class="form-control" value="{{ old('stack') }}">
                                    <label for="stack">@lang('content.admin.products.add.products_in_stack')</label>
                                </div>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-money prefix"></i>
                                    <input type="text" name="price" id="price" class="form-control" value="{{ old('price') }}">
                                    <label for="price">@lang('content.admin.products.add.products_price')</label>
                                </div>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-sort-amount-desc prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="@lang('components.popover.title')" data-html="true" data-content="@lang('content.admin.products.add.sort_priority_popover')"></i>
                                    <input type="text" name="sort_priority" id="admin-product-sort-priority" class="form-control" value="0">
                                    <label for="admin-product-sort-priority">@lang('content.admin.products.add.sort_priority')</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <h4>@lang('content.admin.products.add.attach_server_category')</h4>
                            <div class="btn-group mb-2 mt-1">
                                <button id="edit-categories-clip" class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('content.all.select')</button>

                                <div class="dropdown-menu dropdown-overflow">
                                    <div class="dropdown-divider"></div>
                                    @foreach($servers as $server)
                                        @foreach($server->getCategories() as $category)
                                            <a class="dropdown-item edit-categories-clip-item change" data-server="{{ $server->getId() }}" data-category="{{ $category->getId() }}" data-parent="edit-categories-clip">{{ $server->getName() }} / {{ $category->getName() }}</a>
                                        @endforeach
                                    @endforeach
                                </div>
                                <input type="hidden" name="server" id="server">
                                <input type="hidden" name="category" id="category">
                            </div>
                        </div>

                        <div class="col-sm-6 offset-sm-3 col-12 save-and-del text-center">
                            {{ csrf_field() }}
                            <button class="btn btn-info"><i class="fa fa-check fa-left"></i>@lang('content.admin.products.add.save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
