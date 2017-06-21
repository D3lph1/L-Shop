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

        <form id="admin-users-edit-already-ban" method="post" action="{{ route('admin.users.unblock', ['server' => $currentServer->id, 'user' => $user->id]) }}" @if(!$ban->isBanned()) class="d-none" @endif>
            <div class="alert alert-warning text-center">
                @if($ban->isBanned())
                    {{ build_ban_message($ban->getBan()->until, $ban->getBan()->reason) }}
                @endif
                <span></span>
                {{ csrf_field() }}
                <button class="btn btn-info btn-sm">Разблокировать</button>
            </div>
        </form>

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
                                    <label for="user-email">Адрес электронной почты</label>
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

                            <div class="plus-category text-center">
                                <p>
                                    <a class="btn btn-info" data-toggle="collapse" data-target="#collapseOtherUserActions" aria-expanded="false" aria-controls="collapseOtherUserActions">
                                        Другое
                                    </a>
                                </p>
                                <div class="collapse" id="collapseOtherUserActions">
                                    <div class="md-form text-left">
                                        <a href="{{ route('admin.users.edit.destroy_sessions', ['server' => $currentServer->id, 'user' => $user->id]) }}" class="btn danger-color btn-sm btn-block">Сбросить все логин - сессии данного пользователя</a>
                                    </div>
                                    @if($user->getUserId() !== \Sentinel::getUser()->getUserId())
                                        <div class="md-form text-left mb-3">
                                            <a id="admin-users-edit-ban-open-modal" class="btn btn-warning btn-sm btn-block" data-toggle="modal" data-target="#admin-users-edit-ban-modal">Заблокировать пользователя</a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6 offset-sm-3 col-12 save-and-del text-center">
                            {{ csrf_field() }}
                            <button class="btn btn-info"><i class="fa fa-check fa-left"></i>Сохранить</button>

                            @if($user->getUserId() !== \Sentinel::getUser()->getUserId())
                                <a href="{{ route('admin.users.edit.remove', ['server' => $currentServer->id, 'user' => $user->id]) }}" class="btn danger-color"><i class="fa fa-user-times fa-left"></i>Удалить пользователя</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@component('components.modal')
    @slot('id')
        admin-users-edit-ban-modal
    @endslot
    @slot('title')
        Заблокировать пользователя
    @endslot
    @slot('buttons')
        <button type="button" class="btn btn-warning" id="admin-users-edit-ban" data-url="{{ route('admin.users.block', ['server' => $currentServer->id, 'user' => $user->getUserId()]) }}">Заблокировать</button>
        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Отменить</button>
    @endslot
    <div class="md-form text-left">
        <i class="fa fa-calendar-times-o prefix"  data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-content="Здесь указывается длительность блокировки пользователя в днях. Для того, чтобы заблокировать пользователя навсегда, введите нуль (0)."></i>
        <input type="text" id="admin-users-edit-ban-duration" class="form-control" value="0">
        <label for="admin-users-edit-ban-duration" class="ckeckbox-label">Длительность блокировки</label>
    </div>
    <div class="md-form text-left">
        <i class="fa fa-pencil prefix"  data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-content="Причина блокировки указывается, дабы вы и сам пользователь знали о том, за что его аккаунт заблокировали. Это поле необязательно для заполнения."></i>
        <input type="text" id="admin-users-edit-ban-reason" class="form-control">
        <label for="admin-users-edit-ban-reason" class="ckeckbox-label">Причина блокировки</label>
    </div>
@endcomponent
