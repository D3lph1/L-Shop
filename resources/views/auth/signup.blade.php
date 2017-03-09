{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.auth')

@section('title')
    Регистрация
@endsection

@section('content')
    <div class="full-h flex-center pd-v-form">
        <div class="card no-pdh z-depth-4 col-xl-4 col-md-6 col-11">

            <form method="post" action="{{ route('signup.handle') }}">
                <div class="card-block" id="sign-up">
                    <div class="card-header d_orange text-center white-text z-depth-2">
                        <h1>Регистрация<i class="fa fa-sign-in fa-lg fa-right"></i></h1>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-user fa-lg prefix"></i>
                        <input type="text" name="username" id="su-username" class="form-control">
                        <label for="su-username">Имя пользователя</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-envelope fa-lg prefix"></i>
                        <input type="text" name="email" id="su-email" class="form-control">
                        <label for="su-email">Адрес электронной почты</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-unlock-alt fa-lg prefix"></i>
                        <input type="password" name="password" id="su-password" class="form-control">
                        <label for="su-password">Пароль</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-unlock-alt fa-lg prefix"></i>
                        <input type="password" name="password_confirmation" id="su-password-confirm" class="form-control">
                        <label for="su-password-confirm">Повторите пароль</label>
                    </div>
                    <div class="md-form">
                        {!! \ReCaptcha::render() !!}
                    </div>
                    <div class="col-12 text-center">
                        {{ csrf_field() }}
                        <button class="btn btn-warning btn-lg" id="btn-sign-up">Зарегистрироваться</button>
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
