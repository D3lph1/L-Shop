{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Настройки
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-gear fa-lg fa-left-big"></i>Настройки</h1>
        </div>
        <div class="product-container">
            <div class="card card-block">
                <h3 class="card-title">Безопасность</h3>
                @if($enableChangePassword)
                    <form action="{{ route('profile.settings.password', ['server' => $currentServer->id]) }}" method="POST">
                        <h4 class="card-title">Сменить пароль</h4>
                        <p class="card-text">
                        <div class="md-form">
                            <i class="fa fa-lock prefix"></i>
                            <input type="password" name="password" id="p-password" class="form-control">
                            <label for="p-password">Новый пароль</label>
                        </div>
                        <div class="md-form">
                            <i class="fa fa-lock prefix"></i>
                            <input type="password" name="password_confirmation" id="p-password-confirmation" class="form-control">
                            <label for="p-password-confirmation">Повторите пароль</label>
                        </div>
                        </p>
                        <div class="flex-row">
                            {{ csrf_field() }}
                            <button class="btn btn-info">Сохранить</button>
                        </div>
                    </form>
                @endif
                <h4 class="card-title mt-2">Сброс логин - сессий</h4>
                <p class="card-text">
                    После нажатия на кнопку ниже, все логин - сессии (В том числе и текущая) будут сброшены. Это может оказаться
                    полезным тогда, когда вы хотите выйти из аккаунта на устройствах, к которым у вас нет доступа.
                    <form action="{{ route('profile.settings.sessions', ['server' => $currentServer->id]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="flex-row">
                            <button class="btn danger-color">Сбросить</button>
                        </div>
                    </form>
                </p>
            </div>
        </div>
    </div>
@endsection
