{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.auth')

@section('title')
    Регистрация
@endsection

@section('content')
    <div class="full-h flex-center pd-v-form">
        <div class="card no-pdh z-depth-4 col-xl-4 col-md-6 col-11">

            <form method="post" action="">
                <div class="card-block" id="sign-up">
                    <div class="card-header d_orange text-center white-text z-depth-2">
                        <h1>Активация<i class="fa fa-envelope-o fa-lg fa-right"></i></h1>
                    </div>
                    <div class="md-form">
                        <div class="alert alert-info">
                            На почтовый ящик, указанный вами при регистрации отправлено письмо с подтверждением регистрации.
                            Проверьте почту и перейдите по ссылке в письме.<br>
                            Если письмо не пришло, вы можете отправить его заного.
                        </div>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-envelope fa-lg prefix"></i>
                        <input type="text" name="email" id="su-email" class="form-control">
                        <label for="su-email">Адрес электронной почты</label>
                    </div>
                    <div class="md-form">
                        {!! \ReCaptcha::render() !!}
                    </div>
                    <div class="col-12 text-center">
                        {{ csrf_field() }}
                        <button class="btn btn-warning btn-lg" id="btn-send">Отправить повторно</button>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        @if(access_mode_any() or access_mode_auth())
                            <div class="col-12 text-center">
                                <a href="{{ route('signin') }}"><i class="fa fa-plus fa-left"></i> Вход</a>
                            </div>
                        @endif
                        @if(access_mode_any())
                            <div class="col-12 text-center">
                                <a href="{{ route('servers') }}"><i class="fa fa-shopping-cart"></i> Покупка без авторизации</a>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
