{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.control.payments.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-credit-card fa-left-big"></i>@lang('content.admin.control.payments.title')</h1>
        </div>
        <form method="post" action="{{ route('admin.control.payments.save', ['currentServer' => $currentServer->id]) }}">
            <div class="card card-block">
                <h3 class="card-title">@lang('content.admin.control.payments.common.title')</h3>
                <p class="card-text">
                    <div class="md-form">
                        <i class="fa fa-money prefix"></i>
                        <input type="text" name="min_sum" id="min-sum" class="form-control" value="{{ $minSum }}">
                        <label for="min-sum">@lang('content.admin.control.payments.common.min_sum')</label>
                    </div>
                </p>
                <h4 class="card-title">@lang('content.admin.control.payments.common.currency')</h4>
                <p class="card-text">
                    <div class="md-form">
                        <i class="fa fa-money prefix"></i>
                        <input type="text" name="currency" id="currency" class="form-control" value="{{ $currency }}">
                        <label for="currency">@lang('content.admin.control.payments.common.currency_name')</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-money prefix"></i>
                        <input type="text" name="currency_html" id="currency-html" class="form-control" value="{{ $currencyHtml }}">
                        <label for="currency-html">@lang('content.admin.control.payments.common.currency_html')</label>
                    </div>
                </p>
            </div>
            <div class="card card-block mt-2">
                <h3 class="card-title">@lang('content.admin.control.payments.aggregators.title')</h3>
                <h4 class="card-title">@lang('content.admin.control.payments.aggregators.robokassa.title')</h4>
                <p class="card-text">
                <p class="mt-1">
                    <input type="checkbox" name="robokassa_enabled" id="robokassa-enabled" @if($robokassaEnable) checked="checked" @endif value="1">
                    <label for="robokassa-enabled" class="ckeckbox-label">
                        <span class='ui'></span>
                        @lang('content.admin.control.payments.aggregators.robokassa.enabled')
                    </label>
                </p>
                @lang('content.admin.control.payments.aggregators.robokassa.change_data')
                    <div class="md-form mt-2">
                        <i class="fa fa-user prefix"></i>
                        <input type="text" name="robokassa_login" id="robokassa-login" class="form-control" value="{{ $robokassaLogin }}">
                        <label for="robokassa-login">@lang('content.admin.control.payments.aggregators.robokassa.login')</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input type="text" name="robokassa_password1" id="robokassa-password1" class="form-control" value="{{ $robokassaPassword1 }}">
                        <label for="robokassa-password1">@lang('content.admin.control.payments.aggregators.robokassa.password1')</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input type="text" name="robokassa_password2" id="robokassa-password2" class="form-control" value="{{ $robokassaPassword2 }}">
                        <label for="robokassa-password2">@lang('content.admin.control.payments.aggregators.robokassa.password2')</label>
                    </div>
                    @lang('content.admin.control.payments.aggregators.robokassa.algo')
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
                            @lang('content.admin.control.payments.aggregators.robokassa.is_test')
                        </label>
                    </p>
                </p>

                <h4 class="card-title mt-2">@lang('content.admin.control.payments.aggregators.interkassa.title')</h4>
                <p class="card-text">
                <p class="mt-1">
                    <input type="checkbox" name="interkassa_enabled" id="interkassa-enabled" @if($interkassaEnable) checked="checked" @endif value="1">
                    <label for="interkassa-enabled" class="ckeckbox-label">
                        <span class='ui'></span>
                        @lang('content.admin.control.payments.aggregators.interkassa.enabled')
                    </label>
                </p>
                @lang('content.admin.control.payments.aggregators.interkassa.change_data')
                <div class="md-form mt-2">
                    <i class="fa fa-user prefix"></i>
                    <input type="text" name="interkassa_checkout_id" id="interkassa-checkout-id" class="form-control" value="{{ $interkassaLogin }}">
                    <label for="interkassa-checkout-id">@lang('content.admin.control.payments.aggregators.interkassa.login')</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-lock prefix"></i>
                    <input type="text" name="interkassa_key" id="interkassa-key" class="form-control" value="{{ $interkassaKey }}">
                    <label for="interkassa-key">@lang('content.admin.control.payments.aggregators.interkassa.key')</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-lock prefix"></i>
                    <input type="text" name="interkassa_test_key" id="interkassa-test-key" class="form-control" value="{{ $interkassaTestKey }}">
                    <label for="interkassa-test-key">@lang('content.admin.control.payments.aggregators.interkassa.test_key')</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-money prefix"></i>
                    <input type="text" name="interkassa_currency" id="interkassa-currency" class="form-control" value="{{ $interkassaCurrency }}">
                    <label for="interkassa-currency">@lang('content.admin.control.payments.aggregators.interkassa.currency')</label>
                </div>
                @lang('content.admin.control.payments.aggregators.interkassa.algo')
                <div class="btn-group mt-1 mb-1">
                    <button class="btn btn-info dropdown-toggle" id="interkassa-algo" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $interkassaAlgo }}</button>

                    <div class="dropdown-menu">
                        @foreach($interkassaAlgos as $algo)
                            <a class="dropdown-item interkassa-algo-item change" data-parent="interkassa-algo">{{ $algo }}</a>
                        @endforeach
                    </div>
                    <input type="hidden" name="interkassa_algo" id="interkassa-algo-input" value="{{ $interkassaAlgo }}">
                </div>
                <p class="mt-1">
                    <input type="checkbox" name="interkassa_test" id="interkassa-test" @if($interkassaIsTest) checked="checked" @endif value="1">
                    <label for="interkassa-test" class="ckeckbox-label">
                        <span class='ui'></span>
                        @lang('content.admin.control.payments.aggregators.interkassa.is_test')
                    </label>
                </p>
                </p>
            </div>

            <div class="card card-block mt-5">
                <div class="flex-row">
                    {{ csrf_field() }}
                    <button class="btn btn-info">@lang('content.admin.save')</button>
                </div>
            </div>
        </form>
    </div>
@endsection
