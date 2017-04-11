{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Безопасность
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-lock fa-left-big"></i>Безопасность</h1>
        </div>

        @if(config('app.debug'))
            <div class="alert alert-danger">
                <p><strong>Внимание!</strong> У вас включен режим отладки. Посетители вашего сайта могут видеть отладочную
                информацияю, а также, ошибки. В обязательном порядке отключите этот режим в "продакшене", выставив значение
                элемента <code>APP_DEBUG</code> в файле <code>.env</code> в значение <code>false</code>.</p>
                Чтобы получилось так: <code>APP_DEBUG=false</code>
            </div>
        @endif

        <form method="post" action="{{ route('admin.control.security.save', ['currentServer' => $currentServer->id]) }}">
            <div class="card card-block">
                <h4 class="card-title">Генератор ключей</h4>
                <p class="card-text">
                    <p>Этот инструмент поможет создать ключ приложения:</p>
                    <div class="form-inline">
                        <input type="text" class="form-control" value="{{ $key = 'base64:' . base64_encode(str_random(32)) }}" readonly>
                        <a class="btn btn-info" onclick="prompt('Скопировать', '{{ $key }}')"><i class="fa fa-copy"></i> Копировать</a>
                    </div>
                    <div class="alert alert-info">
                        <p>Установите этот ключ значением элемента <code>APP_KEY</code> в файле <code>.env</code></p>
                        Должно получиться так: <code>APP_KEY={{ $key }}</code>
                    </div>
                    <div class="alert alert-warning">
                        <strong>Внимание!</strong> После изменения ключа приложения все пользователи (в том числе и вы) будут разлогинены.
                    </div>

                    <p class="mt-2">А этот - ключ сессии:</p>
                    <div class="form-inline">
                        <input type="text" class="form-control" value="{{ $key = str_random(32) }}" readonly>
                        <a class="btn btn-info" onclick="prompt('Скопировать', '{{ $key }}')"><i class="fa fa-copy"></i> Копировать</a>
                    </div>
                    <div class="alert alert-info">
                        <p>Установите этот ключ значением элемента <code>APP_AUTH_KEY</code> в файле <code>.env</code></p>
                        Должно получиться так: <code>APP_AUTH_KEY={{ $key }}</code>
                    </div>
                    <div class="alert alert-warning">
                        Никогда и никому не сообщайте эти ключи! В противном случае, безопасность приложения будет под угрозой.
                    </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">ReCAPTCHA</h4>
                <p class="card-text">
                    <p>Изменение ключей сервиса ReCAPTCHA.</p>
                    <div class="md-form mt-1">
                        <i class="fa fa-google prefix"></i>
                        <input type="text" name="recaptcha_public_key" id="sec-recaptcha-public-key" class="form-control" value="{{ $recaptchaPublicKey }}">
                        <label for="sec-recaptcha-public-key">Публичный ключ</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-google prefix"></i>
                        <input type="text" name="recaptcha_secret_key" id="sec-recaptcha-secret-key" class="form-control" value="{{ $recaptchaSecretKey }}">
                        <label for="sec-recaptcha-secret-key">Секретный ключ</label>
                    </div>
                </p>
                <div class="flex-row">
                    <a class="btn btn-info" data-toggle="modal" data-target="#recaptcha-example-modal">Проверить</a>
                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Пользователь</h4>
                <p class="card-text">
                <div class="md-form mt-1">
                    <input type="checkbox" name="enable_change_password" id="enable-change-password" @if($enabledChangePassword) checked="checked" @endif value="1">
                    <label for="enable-change-password" class="ckeckbox-label">
                        <span class='ui'></span>
                        Разрешить пользователю менять пароль от своего аккаунта
                    </label>
                </div>
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
    <div class="modal fade" id="recaptcha-example-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100" id="myModalLabel">Проверка ReCAPTCHA</h4>
                </div>
                <div class="modal-body">
                    {!! ReCaptcha::render() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Понятно</button>
                </div>
            </div>
        </div>
    </div>
@endsection
