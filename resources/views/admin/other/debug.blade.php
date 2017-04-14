{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Отладка
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-free-code-camp fa-left-big"></i>Отладка</h1>
        </div>
        <div class="product-container">
            <div class="card card-block">
                <h4 class="card-title">Почта</h4>
                <p class="card-text">
                    Тестовое письмо поможет проверить как работает функция отправки email-сообщений.
                <form method="post" action="{{ route('admin.other.test_mail', ['server' => $currentServer->id]) }}">
                    <div class="md-form mt-1">
                        <i class="fa fa-envelope-o prefix"></i>
                        <input type="text" name="test_mail_address" id="debug-test-mail-address" class="form-control">
                        <label for="debug-test-mail-address">Адрес электронной почты, на который будет отправлено письмо</label>

                        {{ csrf_field() }}
                        <button class="btn btn-info">Отправить</button>
                    </div>
                    @if(\Session::has('test_mail_exception'))
                        Во время отправки сообщения произошла ошибка:
                        <div class="alert alert-danger mt-1" style="font-size: 80%">
                            {{ \Session::get('test_mail_exception') }}
                        </div>
                        Полные сведения о ней, а так же стэк трейс были записаны в лог.
                    @endif
                </form>
                </p>
            </div>
        </div>
    </div>
@endsection