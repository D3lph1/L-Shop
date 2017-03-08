{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Редактировать пользователя
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-user fa-lg fa-left-big"></i>Редактировать пользователя {{ $user->username }}</h1>
        </div>
        <form method="post" action="{{ route('admin.users.edit.save', ['server' => $currentServer->id, 'edit' => $user->id]) }}">
            <div id="s-change-name" class="mt-3">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 offset-xs-0">
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3 col-12 text-center">
                            <div class="md-form text-left">
                                <i class="fa fa-user prefix"></i>
                                <input type="text" name="username" id="user-name" class="form-control" value="{{ $user->username }}">
                                <label for="user-name">Имя пользователя</label>
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
                                    <i class="fa fa-envelope-o prefix"></i>
                                    <input type="text" name="email" id="user-email" class="form-control" value="{{ $user->email }}">
                                    <label for="user-email">Почта</label>
                                </div>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-money prefix"></i>
                                    <input type="text" name="balance" id="user-balance" class="form-control" value="{{ $user->balance }}">
                                    <label for="user-balance">Баланс</label>
                                </div>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left">
                                    <i class="fa fa-lock prefix"></i>
                                    <input type="password" name="password" id="user-password" class="form-control">
                                    <label for="user-password">Новый пароль</label>
                                </div>
                            </div>
                            <div class="plus-category">
                                <div class="md-form text-left mb-3">
                                    <input type="checkbox" name="admin" id="user-admin" @if($user->hasAccess('user.admin')) checked="checked" @endif value="1">
                                    <label for="user-admin" class="ckeckbox-label">
                                        <span class='ui'></span>
                                        Администратор
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-3 col-12 save-and-del text-center">
                            {{ csrf_field() }}
                            <button class="btn btn-info"><i class="fa fa-check fa-left"></i>Сохранить</button>
                            <a href="{{ route('admin.users.edit.remove', ['server' => $currentServer->id, 'user' => $user->id]) }}" class="btn danger-color"><i class="fa fa-user-times fa-left"></i>Удалить пользователя</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
