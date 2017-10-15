{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.servers.edit.title', ['name' => $server->getName()])
@endsection

@section('content')
    <div id="content-container">
        <div class="content-header text-center z-depth-1">
            <h1><i class="fa fa-server fa-left-big"></i>@lang('content.admin.servers.edit.title', ['name' => $server->getName()])</h1>
        </div>
        <form method="post" action="{{ route('admin.servers.edit.save', ['server' => $currentServer->getId(), 'edit' => $server->getId()]) }}">
            <div id="s-change-name">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <div class="md-form text-left">
                                <i class="fa fa-refresh prefix"></i>
                                <input type="text" name="server_name" id="server-name" class="form-control" value="{{ $server->getName() }}">
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
                            <div class="all-cat text-left">
                                @foreach($categories as $category)
                                    <div class="s-set-category">
                                        <div class="md-form">
                                            <i class="fa fa-dot-circle-o prefix"></i>
                                            <input type="text" name="categories[{{ $category->getId() }}][]" id="cat{{ $category->getId() }}" class="form-control" value="{{ $category->getName() }}">
                                            <label for="cat{{ $category->getId() }}">@lang('content.admin.servers.add.categories.name')</label>
                                        </div>
                                        <a class="btn danger-color server-edit-remove-category" data-category="{{ $category->id }}" data-url="{{ route('admin.servers.edit.remove_category', ['server' => $currentServer->getId(), 'edit' => $server->getId()]) }}"><i class="fa fa-times fa-lg"></i></a>
                                    </div>
                                @endforeach
                            </div>

                            <div class="plus-category">
                                <div class="md-form">
                                    <i class="fa fa-plus prefix"></i>
                                    <input type="text" id="server-edit-add-category-input" class="form-control">
                                    <label for="server-edit-add-category-input">@lang('content.admin.servers.edit.new_category_name')</label>
                                    <a id="server-edit-add-category" class="btn green btn-block" data-url="{{ route('admin.servers.edit.add_category', ['server' => $currentServer->getId(), 'edit' => $server->getId()]) }}"><i class="fa fa-plus fa-left"></i>@lang('content.admin.servers.edit.add')</a>
                                </div>
                            </div>

                            <div class="plus-category">
                                <div class="row">
                                    <div class="col-md-8 md-form text-left">
                                        <input type="text" name="server_ip" id="admin-servers-ip" class="form-control" value="{{ $server->getIp() }}">
                                        <label for="admin-servers-ip">@lang('content.admin.servers.add.ip')</label>
                                    </div>
                                    <div class="col-md-4 md-form text-left">
                                        <input type="text" name="server_port" id="admin-servers-port" class="form-control" value="{{ $server->getPort() }}">
                                        <label for="admin-servers-port">@lang('content.admin.servers.add.port')</label>
                                    </div>
                                </div>
                                <div class="md-form text-left">
                                    <input type="password" name="server_password" id="admin-servers-password" class="form-control" value="{{ $server->getPassword() }}">
                                    <label for="admin-servers-password">@lang('content.admin.servers.add.password')</label>
                                </div>
                                <div class="text-left">
                                    <input type="checkbox" name="server_monitoring_enabled" id="admin-servers-monitoring" @if($server->isMonitoringEnabled()) checked="checked" @endif value="1">
                                    <label for="admin-servers-monitoring" class="ckeckbox-label">
                                        <span class='ui'></span>
                                        @lang('content.admin.servers.add.monitoring')
                                    </label>
                                </div>
                            </div>

                            <div class="mt-2 mb-1">
                                <input type="checkbox" name="enabled" id="server-edit-enabled" @if($server->isEnabled()) checked="checked" @endif value="1">
                                <label for="server-edit-enabled" class="ckeckbox-label">
                                    <span class='ui'></span>
                                    @lang('content.admin.servers.add.enable')
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-3 col-12 save-and-del text-center">
                            {{ csrf_field() }}
                            <button class="btn btn-info"><i class="fa fa-check fa-left"></i>@lang('content.admin.servers.add.save')</button>
                            <a href="{{ route('admin.servers.remove', ['server' => $currentServer->getId(), 'remove' => $server->getId()]) }}" class="btn danger-color"><i class="fa fa-times fa-left"></i>@lang('content.admin.servers.edit.remove')</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
