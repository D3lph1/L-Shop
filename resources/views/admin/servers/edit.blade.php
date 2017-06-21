{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Редактировать сервер {{ $server->name }}
@endsection

@section('content')
    <div id="content-container">
        <div class="content-header text-center z-depth-1">
            <h1><i class="fa fa-server fa-left-big"></i>Редактировать сервер {{ $server->name }}</h1>
        </div>
        <form method="post" action="{{ route('admin.servers.edit.save', ['server' => $currentServer->id, 'edit' => $server->id]) }}">
            <div id="s-change-name">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <div class="md-form text-left">
                                <i class="fa fa-refresh prefix"></i>
                                <input type="text" name="server_name" id="server-name" class="form-control" value="{{ $server->name }}">
                                <label for="server-name">Имя сервера</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="s-settings-cat">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-12 text-center s-s-header">
                            <h3>Категории:</h3>
                        </div>
                        <div class="col-sm-6 offset-sm-3 col-12">
                            <div class="all-cat text-left">
                                @foreach($categories as $category)
                                    <div class="s-set-category">
                                        <div class="md-form">
                                            <i class="fa fa-dot-circle-o prefix"></i>
                                            <input type="text" name="categories[{{ $category->id }}][]" id="cat{{ $category->id }}" class="form-control" value="{{ $category->name }}">
                                            <label for="cat{{ $category->id }}">Имя категории</label>
                                        </div>
                                        <a class="btn danger-color server-edit-remove-category" data-category="{{ $category->id }}" data-url="{{ route('admin.servers.edit.remove_category', ['server' => $currentServer->id, 'edit' => $server->id]) }}"><i class="fa fa-times fa-lg"></i></a>
                                    </div>
                                @endforeach
                            </div>

                            <div class="plus-category">
                                <div class="md-form">
                                    <i class="fa fa-plus prefix"></i>
                                    <input type="text" id="server-edit-add-category-input" class="form-control">
                                    <label for="server-edit-add-category-input">Имя новой категории</label>
                                    <a id="server-edit-add-category" class="btn green btn-block" data-url="{{ route('admin.servers.edit.add_category', ['server' => $currentServer->id, 'edit' => $server->id]) }}"><i class="fa fa-plus fa-left"></i>Добавить категорию</a>
                                </div>
                            </div>

                            <div class="plus-category">
                                <div class="row">
                                    <div class="col-md-8 md-form text-left">
                                        <input type="text" name="server_ip" id="admin-servers-ip" class="form-control" value="{{ $server->ip }}">
                                        <label for="admin-servers-ip">IP-адрес сервера</label>
                                    </div>
                                    <div class="col-md-4 md-form text-left">
                                        <input type="text" name="server_port" id="admin-servers-port" class="form-control" value="{{ $server->port }}">
                                        <label for="admin-servers-port">Порт сервера</label>
                                    </div>
                                </div>
                                <div class="md-form text-left">
                                    <input type="password" name="server_password" id="admin-servers-password" class="form-control" value="{{ $server->password }}">
                                    <label for="admin-servers-password">RCON пароль</label>
                                </div>
                                <div class="text-left">
                                    <input type="checkbox" name="server_monitoring_enabled" id="admin-servers-monitoring" @if($server->monitoring_enabled) checked="checked" @endif value="1">
                                    <label for="admin-servers-monitoring" class="ckeckbox-label">
                                        <span class='ui'></span>
                                        Включить мониторинг сервера
                                    </label>
                                </div>
                            </div>

                            <div class="mt-2 mb-1">
                                <input type="checkbox" name="enabled" id="server-edit-enabled" @if($server->enabled) checked="checked" @endif value="1">
                                <label for="server-edit-enabled" class="ckeckbox-label">
                                    <span class='ui'></span>
                                    Включить сервер
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-3 col-12 save-and-del text-center">
                            {{ csrf_field() }}
                            <button class="btn btn-info"><i class="fa fa-check fa-left"></i>Сохранить</button>
                            <a href="{{ route('admin.servers.remove', ['server' => $currentServer->id, 'remove' => $server->id]) }}" class="btn danger-color"><i class="fa fa-times fa-left"></i>Удалить сервер</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
