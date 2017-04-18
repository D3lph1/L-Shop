{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    API
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-cog fa-spin fa-left-big"></i>API</h1>
        </div>
        <div class="product-container">
            @if(!$enabled)
                <div class="alert alert-warning">
                    <button id="admin-api-enable-alert-close" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Не забудьте включить API, перед началом его использования.
                </div>
            @endif
            <div class="alert alert-info">
                <button id="admin-api-docs-alert-close" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                    <h4 class="card-title">API - аутентификация</h4>
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
                                Запоминать аутентифицированных пользователей
                            </label>
                        </p>
                    </p>
                    <h4 class="card-title">API - регистрация</h4>
                    <p class="card-text">
                    <p>
                        <input type="checkbox" name="signup_enabled" id="api-signup-enabled" @if($signupEnabled) checked="checked" @endif value="1">
                        <label for="api-signup-enabled" class="ckeckbox-label">
                            <span class='ui'></span>
                            Включить
                        </label>
                    </p>
                    </p>
                </div>

                <div class="card card-block mt-2">
                    <h4 class="card-title">Интеграция с Sashok724's Launcher</h4>
                    <p class="card-text">
                        <p>
                            <input type="checkbox" name="sashok_launcher_auth_enabled" id="api-sashok-launcher-auth-enabled" @if($sashokAuthEnabled) checked="checked" @endif value="1">
                            <label for="api-sashok-launcher-auth-enabled" class="ckeckbox-label">
                                <span class='ui'></span>
                                Включить
                            </label>
                        </p>

                        <p>
                            Формат успешного ответа сервиса. Данная строка будет "выведена" лаунчсерверу при успешной проверке введенных данных.
                            Маркер {username} будет заменен на имя пользователя. Например, если формат ответа OK:{username}, при успешной
                            проверке данных пользователя D3lph1, сервер получит ответ: OK:D3lph1
                            <div class="md-form mt-1">
                                <i class="fa fa-commenting-o prefix"></i>
                                <input type="text" name="sashok_launcher_auth_format" id="api-sashok-launcher-format" class="form-control" value="{{ $sashokAuthFormat }}">
                                <label for="api-sashok-launcher-format">Формат</label>
                            </div>
                        </p>

                        <p>
                            <div class="md-form">
                                <i class="fa fa-exclamation-triangle prefix"></i>
                                <input type="text" name="sashok_launcher_auth_error_message" id="api-sashok-launcher-error-message" class="form-control" value="{{ $sashokAuthErrorMessage }}">
                                <label for="api-sashok-launcher-error-message">Сообщение при неверном вводе данных пользователем</label>
                            </div>
                        </p>

                        <p>
                            Ниже вы можете ввести список ip-адресов, которые могут соединяться с L-Shop и проверять данные пользователей для авторизации в лаунчере.
                            Мы рекомендуем указать здесь ip вашего лаунчсервера. Оставьте поле пустым, дабы не использовать блокировку посторонних адресов (Не рекомендуется).
                            <div class="md-form mt-1">
                                <i class="fa fa-sticky-note-o prefix"></i>
                                <input type="text" name="sashok_launcher_auth_white_list" id="api-sashok-launcher-white-list" class="form-control" value="{{ $sashokAuthWhiteList }}">
                                <label for="api-sashok-launcher-white-list">Список разрешенных IP адресов (Разделитель - запятая. Например: 127.0.0.1, 192.168.0.1).</label>
                            </div>
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
    </div>
@endsection
