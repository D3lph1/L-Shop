{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Платежи
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-credit-card fa-left-big"></i>Платежи</h1>
        </div>
        <form method="post" action="{{ route('admin.control.payments.save', ['currentServer' => $currentServer->id]) }}">
            <div class="card card-block">
                <h3 class="card-title">Общее</h3>
                <h4 class="card-title">Минимальная сумма пополнения баланса</h4>
                <p class="card-text">
                    <div class="md-form">
                        <i class="fa fa-money prefix"></i>
                        <input type="text" name="min_sum" id="min-sum" class="form-control" value="{{ $minSum }}">
                        <label for="min-sum">Сумма</label>
                    </div>
                </p>
                <h4 class="card-title">Валюта</h4>
                <p class="card-text">
                    <div class="md-form">
                        <i class="fa fa-money prefix"></i>
                        <input type="text" name="currency" id="currency" class="form-control" value="{{ $currency }}">
                        <label for="currency">Название валюты</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-money prefix"></i>
                        <input type="text" name="currency_html" id="currency-html" class="form-control" value="{{ $currencyHtml }}">
                        <label for="currency-html">HTML представление валюты</label>
                    </div>
                </p>
            </div>
            <div class="card card-block mt-2">
                <h3 class="card-title">Платежные агрегаторы</h3>
                <h4 class="card-title">Robokassa</h4>
                <p class="card-text">
                    Изменение персональных данных сервиса Robokassa
                    <div class="md-form">
                        <i class="fa fa-money prefix"></i>
                        <input type="text" name="robokassa_login" id="robokassa-login" class="form-control" value="{{ $robokassaLogin }}">
                        <label for="robokassa-login">Логин</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-money prefix"></i>
                        <input type="text" name="robokassa_password1" id="robokassa-password1" class="form-control" value="{{ $robokassaPassword1 }}">
                        <label for="robokassa-password1">Пароль №1</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-money prefix"></i>
                        <input type="text" name="robokassa_password2" id="robokassa-password2" class="form-control" value="{{ $robokassaPassword2 }}">
                        <label for="robokassa-password2">Пароль №2</label>
                    </div>
                    Алгоритм расчета контрольной суммы:
                    <div class="btn-group mt-1 mb-1">
                        <button class="btn btn-info dropdown-toggle" id="robokassa-algo" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $robokassaAlgo }}</button>

                        <div class="dropdown-menu">
                            @foreach($robokassaAlgos as $algo)
                                <a class="dropdown-item robokassa-algo-item change" data-parent="robokassa-algo">{{ $algo }}</a>
                            @endforeach
                        </div>
                        <input type="hidden" name="robokassa_algo" id="robokassa-algo-input" value="{{ $robokassaAlgo }}">
                    </div>
                    <p class="mt-1">
                        <input type="checkbox" name="robokassa_test" id="robokassa-test" @if($robokassaIsTest) checked="checked" @endif value="1">
                        <label for="robokassa-test" class="ckeckbox-label">
                            <span class='ui'></span>
                            Тестовый режим
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
