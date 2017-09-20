{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.servers.add.title')
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-server fa-lg fa-left-big"></i>@lang('content.admin.servers.add.title')</h1>
        </div>

        <form method="post" action="{{ route('admin.servers.add.save', ['server' => $currentServer->getId()]) }}">
            <div id="s-change-name">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <div class="md-form text-left">
                                <i class="fa fa-refresh prefix"></i>
                                <input type="text" name="server_name" id="server-name" class="form-control" value="{{ old('server_name') }}">
                                <label for="server-name">@lang('content.admin.servers.add.name')</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="s-settings-cat">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-12 text-center s-s-header">
                            <h3>@lang('content.admin.servers.add.categories.title')</h3>
                        </div>
                        <div class="col-sm-6 offset-sm-3 col-12">
                            <div id="server-add-categories" class="all-cat text-left">
                                <div class="s-set-category">
                                    <div class="md-form">
                                        <i class="fa fa-dot-circle-o prefix"></i>
                                        <input type="text" name="categories[]" id="cat" class="form-control category-name">
                                        <label class="category-name-label" for="cat">@lang('content.admin.servers.add.categories.name')</label>
                                    </div>
                                    <a class="btn danger-color server-add-remove-category"><i class="fa fa-times fa-lg"></i></a>
                                </div>
                            </div>

                            <div class="plus-category">
                                <div class="md-form">
                                    <a id="server-add-add-category" class="btn green btn-block"><i class="fa fa-plus fa-left"></i>@lang('content.admin.servers.add.categories.add')</a>
                                </div>
                            </div>

                            <div class="plus-category">
                                <div class="row">
                                    <div class="col-md-8 md-form text-left">
                                        <input type="text" name="server_ip" id="admin-servers-ip" class="form-control" value="">
                                        <label for="admin-servers-ip">@lang('content.admin.servers.add.ip')</label>
                                    </div>
                                    <div class="col-md-4 md-form text-left">
                                        <input type="text" name="server_port" id="admin-servers-port" class="form-control" value="25575">
                                        <label for="admin-servers-port">@lang('content.admin.servers.add.port')</label>
                                    </div>
                                </div>
                                <div class="md-form text-left mb-3">
                                    <input type="password" name="server_password" id="admin-servers-password" class="form-control" value="">
                                    <label for="admin-servers-password">@lang('content.admin.servers.add.password')</label>
                                </div>
                                <div class="text-left">
                                    <input type="checkbox" name="server_monitoring_enabled" id="admin-servers-monitoring" value="1">
                                    <label for="admin-servers-monitoring" class="ckeckbox-label">
                                        <span class='ui'></span>
                                        @lang('content.admin.servers.add.monitoring')
                                    </label>
                                </div>
                            </div>

                            <div class="mt-2 mb-1">
                                <input type="checkbox" name="enabled" id="server-edit-enabled" checked="checked" value="1">
                                <label for="server-edit-enabled" class="ckeckbox-label">
                                    <span class='ui'></span>
                                    @lang('content.admin.servers.add.enable')
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-3 col-12 save-and-del text-center">
                            {{ csrf_field() }}
                            <button class="btn btn-info"><i class="fa fa-check fa-left"></i>@lang('content.admin.servers.add.save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
