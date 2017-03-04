@extends('layouts.shop')

@section('title')
    API
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-cog fa-spin fa-left-big"></i>API</h1>
        </div>
        <div class="alert alert-info">
            Подробную документацию по API вы можете найти <a href="{{ route('admin.info.docs.api', ['server' => $currentServer->id]) }}" class="btn btn-info btn-sm">тут</a>.
        </div>
        <form method="post" action="{{ route('admin.control.api.save', ['server' => $currentServer->id]) }}">
            <div class="card card-block">
                <h4 class="card-title">Включить API</h4>
                <p class="card-text">
                    <input type="checkbox" name="enabled" id="api-enabled" @if($enabled) checked="checked" @endif value="1">
                    <label for="api-enabled" class="ckeckbox-label">
                        <span class='ui'></span>
                        Включить
                    </label>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Ключ доступа</h4>
                <p class="card-text">
                    С помощью данного ключа будут происходить все взаимодействия вашего ресурса с API l-shop.
                    Длина ключа не должна быть меньше 32 символов.
                    <div class="md-form mt-1">
                        <i class="fa fa-key prefix"></i>
                        <input type="text" name="key" id="api-key" class="form-control" value="{!! $key !!}">
                        <label for="api-key">Секретный ключ</label>
                    </div>

                    <div class="alert alert-warning">
                        Никогда и никому не сообщайте этот ключ! В противном случае, безопасность приложения будет под угрозой.
                    </div>
                </p>
                <div class="flex-row">

                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Алгоритм хэширования</h4>
                <p class="card-text">
                При помощи этого алгоритма будет высчитываться контрольная сумма строки. Это необходимо для выполнения безопасного запроса к api.
                <div class="btn-group mb-1 mr-5">
                    <button class="btn btn-info dropdown-toggle" id="api-algo-dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $algo }}</button>

                    <div class="dropdown-menu">
                        @foreach($algos as $one)
                            <a class="dropdown-item api-algo-dropdown-item change" data-parent="api-algo-dropdown">{{ $one }}</a>
                        @endforeach
                    </div>
                    <input type="hidden" name="algo" id="s-api-algo" value="{{ $algo }}">
                </div>

                <div class="alert alert-warning">
                    Мы <strong>не рекомендуем</strong> использовать алгоритм <strong>md5</strong>, в силу его низкой устойчивости к перебору.
                </div>
                </p>
                <div class="flex-row">

                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Разделитель аргументов</h4>
                <p class="card-text">
                    Этот символ будет разделять параметры в строке, из которой будет расчитываться контрольная сумма.
                <div class="md-form mt-1">
                    <i class="fa fa-link prefix"></i>
                    <input type="text" name="separator" id="api-separator" class="form-control" value="{!! $separator !!}">
                    <label for="api-separator">Разделитель</label>
                </div>
                </p>
                <div class="flex-row">

                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Соль</h4>
                <p class="card-text">
                    <p>
                        <input type="checkbox" name="salt" id="api-salt" @if($salt) checked="checked" @endif value="1">
                        <label for="api-salt" class="ckeckbox-label">
                            <span class='ui'></span>
                            Использовать соль
                        </label>
                    </p>
                </p>
                <div class="flex-row">

                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">API - авторизация</h4>
                <p class="card-text">
                    <p>
                        <input type="checkbox" name="signin_enabled" id="api-signin-enabled" @if($signinEnabeld) checked="checked" @endif value="1">
                        <label for="api-signin-enabled" class="ckeckbox-label">
                            <span class='ui'></span>
                            Включить
                        </label>
                    </p>

                    <p>
                        <input type="checkbox" name="signin_remember" id="api-signin-remember" @if($signinRemember) checked="checked" @endif value="1">
                        <label for="api-signin-remember" class="ckeckbox-label">
                            <span class='ui'></span>
                            Запоминать авторизованных пользователей
                        </label>
                    </p>
                </p>
            </div>

            <div class="card card-block mt-5">
                <div class="flex-row">
                    {{ csrf_field() }}
                    <button class="btn btn-info">Сохранить изменения</button>
                </div>
            </div>
        </form>
    </div>
@endsection
