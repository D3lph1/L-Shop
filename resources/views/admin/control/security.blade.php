@extends('layouts.shop')

@section('title')
    Безопасность
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-lock fa-left-big"></i>Безопасность</h1>
        </div>

        @if(config('app.debug'))
            <div class="alert alert-danger">
                <p><strong>Внимание!</strong> У вас включен режим отладки. Посетители вашего сайта могут видеть отладочную
                информацияю, а также, ошибки. В обязательном порядке отключите этот режим в "продакшене", выставив значение
                элемента <code>debug</code> массива в файле <code>config/app.php</code>.</p>
                Чтобы получилось так: <code>'debug' => false,</code>
            </div>
        @endif

        <div class="card card-block">
            <h4 class="card-title">Генератор ключей</h4>
            <p class="card-text">
                <p>Этот инструмент поможет создать ключ приложения:</p>
                <form class="form-inline">
                    <input type="text" class="form-control" value="{{ $key = 'base64:' . base64_encode(str_random(32)) }}" readonly>
                    <button class="btn btn-info" onclick="prompt('Скопировать', '{{ $key }}')"><i class="fa fa-copy"></i> Копировать</button>
                </form>
                <div class="alert alert-info">
                    <p>Установите этот ключ значением элемента <code>key</code> массива в файле <code>config/app.php</code></p>.
                    Должно получиться так: <code>'key' => '{{ $key }}',</code>
                </div>
                <div class="alert alert-warning">
                    <strong>Внимание!</strong> После изменения ключа приложения все пользователи (в том числе и вы) будут разлогинены.
                </div>

                <p class="mt-2">А этот - ключ сессии:</p>
                <form class="form-inline">
                    <input type="text" class="form-control" value="{{ $key = str_random(32) }}" readonly>
                    <button class="btn btn-info" onclick="prompt('Скопировать', '{{ $key }}')"><i class="fa fa-copy"></i> Копировать</button>
                </form>
                <div class="alert alert-info">
                    <p>Установите этот ключ значением элемента <code>session</code> массива в файле <code>config/cartalyst.sentinel.php</code></p>
                    Должно получиться так: <code>'session' => '{{ $key }}',</code>
                </div>
                <div class="alert alert-warning">
                    Никогда и никому не сообщайте эти ключи! В противном случае, безопасность приложения будет под угрозой.
                </div>
            </p>
        </div>
        <div class="card card-block mt-2">
            <h4 class="card-title">Просмотр логов</h4>
            <p class="card-text">
            <p>Здесь вы можете просмотреть содержимое логов приложения</p>
            </p>
        </div>
    </div>
@endsection
