{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.items.edit.title')
@endsection

@section('content')
    @include('components.localization.admin.items')

    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-diamond fa-lg fa-left-big"></i>@lang('content.admin.items.edit.title')</h1>
        </div>
        <form method="post" action="{{ route('admin.items.edit.save', ['server' => $currentServer->getId(), 'item' => $item->getId()]) }}" enctype="multipart/form-data">
            <div id="s-change-name" class="mt-3">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <div class="md-form text-left">
                                <i class="fa fa-font prefix"></i>
                                <input type="text" name="name" id="item-name" class="form-control" value="{{ $item->getName() }}">
                                <label for="item-name">@if($item->getType() === 'item') @lang('content.admin.items.add.item_name') @elseif($item->getType() === 'permgroup') @lang('content.admin.items.add.perm_name') @endif</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="s-settings-cat">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12">
                            <h4 class="text-center">@lang('content.admin.items.add.type.title')</h4>
                            <div class="plus-category text-center mt-1 mb-3">
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info @if($item->getType() === 'item') active @endif">
                                        <input type="radio" name="item_type" id="item-set-item-type" autocomplete="off" value="item" @if($item->getType() === 'item') checked @endif> @lang('content.admin.items.add.type.item')
                                    </label>
                                    <label class="btn btn-info @if($item->getType() === 'permgroup') active @endif">
                                        <input type="radio" name="item_type" id="item-set-permgroup-type" autocomplete="off" value="permgroup" @if($item->getType() === 'permgroup') checked @endif> @lang('content.admin.items.add.type.perm')
                                    </label>
                                </div>
                            </div>

                            <h4 class="text-center">@lang('content.admin.items.add.image.title')</h4>
                            <div class="plus-category text-center mt-1 mb-3">
                                <div class="btn-group" data-toggle="buttons">
                                    @if($item->image)
                                        <label class="btn btn-info active">
                                            <input type="radio" name="image_mode" id="item-set-current-image" autocomplete="off" value="current" checked> @lang('content.admin.items.edit.image.current')
                                        </label>
                                    @endif
                                    <label class="btn btn-info @if(!$item->getImage()) active @endif">
                                        <input type="radio" name="image_mode" id="item-set-default-image" autocomplete="off" value="default" @if(!$item->getImage()) checked @endif> @lang('content.admin.items.add.image.default')
                                    </label>
                                    <label class="btn btn-info">
                                        <input type="radio" name="image_mode" id="item-set-uploaded-image" autocomplete="off" value="upload"> @lang('content.admin.items.add.image.load')
                                    </label>
                                </div>
                            </div>
                            <div id="item-load-image-block" class="plus-category text-center mt-1 mb-3" style="display: none">
                                <label for="upload-img" class="btn btn-warning" style="display: inline-block;">@lang('content.admin.items.add.image.select') <i class="fa fa-download"></i></label>
                                <input style="display: none;" type="file" name="image" id="upload-img" accept="image/*" onchange="$('#file-location').val($('#upload-img').val());">

                                <input type="text" id="file-location" placeholder="@lang('content.admin.items.add.image.not_selected')" readonly>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-list prefix"></i>
                                    <input type="text" name="item" id="item" class="form-control" value="{{ $item->getItem() }}">
                                    <label for="item">@if($item->getType() === 'item') @lang('content.admin.items.add.item_id') @elseif($item->getType() === 'permgroup') @lang('content.admin.items.add.perm_id') @endif</label>
                                </div>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left" @if($item->getType() === 'permgroup') style="display: none;" @endif>
                                    <i class="fa fa-list prefix"></i>
                                    <input type="text" name="extra" id="extra" class="form-control" value="{{ $item->getExtra() }}">
                                    <label for="extra">@lang('content.admin.items.add.extra')</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-3 col-12 save-and-del text-center">
                            {{ csrf_field() }}
                            <button class="btn btn-info"><i class="fa fa-check fa-left"></i>@lang('content.all.save')</button>
                            <a href="{{ route('admin.items.edit.remove', ['server' => $currentServer->getId(), 'item' => $item->getId()]) }}" class="btn danger-color"><i class="fa fa-times fa-left"></i>@lang('content.admin.items.edit.remove')</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
