{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.control.api.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-cog fa-spin fa-left-big"></i>@lang('content.admin.control.api.title')</h1>
        </div>
        <div class="product-container">
            @if(!$enabled)
                <div class="alert alert-warning">
                    <button id="admin-api-enable-alert-close" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    @lang('content.admin.control.api.api_enable_alert')
                </div>
            @endif
            <div class="alert alert-info">
                <button id="admin-api-docs-alert-close" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @lang('content.admin.control.api.api_doc_alert') <a href="{{ route('admin.info.docs.api', ['server' => $currentServer->id]) }}" class="btn btn-info btn-sm">@lang('content.admin.control.api.api_doc_alert_btn')</a>.
            </div>
            <form method="post" action="{{ route('admin.control.api.save', ['server' => $currentServer->id]) }}">
                <div class="card card-block">
                    <h4 class="card-title">@lang('content.admin.control.api.enable_api.title')</h4>
                    <p class="card-text mt-1">
                        <input type="checkbox" name="enabled" id="api-enabled" @if($enabled) checked="checked" @endif value="1">
                        <label for="api-enabled" class="ckeckbox-label">
                            <span class='ui'></span>
                            @lang('content.admin.control.api.enable_api.enable')
                        </label>
                    </p>
                </div>

                <div class="card card-block mt-2">
                    <h4 class="card-title">Ключ доступа</h4>
                    <p class="card-text">
                        @lang('content.admin.control.api.key.description')
                        <div class="md-form mt-1">
                            <i class="fa fa-key prefix"></i>
                            <input type="text" name="key" id="api-key" class="form-control" value="{!! $key !!}">
                            <label for="api-key">@lang('content.admin.control.api.key.secret_key')</label>
                        </div>

                        <div class="alert alert-warning">
                            @lang('content.admin.control.api.key.alert')
                        </div>
                    </p>
                </div>

                <div class="card card-block mt-2">
                    <h4 class="card-title">@lang('content.admin.control.api.algo.title')</h4>
                    <p class="card-text">
                    @lang('content.admin.control.api.algo.description')
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
                        @lang('content.admin.control.api.algo.alert')
                    </div>
                    </p>
                </div>

                <div class="card card-block mt-2">
                    <h4 class="card-title">@lang('content.admin.control.api.separator.title')</h4>
                    <p class="card-text">
                    @lang('content.admin.control.api.separator.description')
                    <div class="md-form mt-1">
                        <i class="fa fa-link prefix"></i>
                        <input type="text" name="separator" id="api-separator" class="form-control" value="{!! $separator !!}">
                        <label for="api-separator">@lang('content.admin.control.api.separator.input')</label>
                    </div>
                    </p>
                </div>

                <div class="card card-block mt-2">
                    <h4 class="card-title">@lang('content.admin.control.api.auth.title')</h4>
                    <p class="card-text">
                        <p>
                            <input type="checkbox" name="signin_enabled" id="api-signin-enabled" @if($signinEnabeld) checked="checked" @endif value="1">
                            <label for="api-signin-enabled" class="ckeckbox-label">
                                <span class='ui'></span>
                                @lang('content.admin.control.api.auth.enable')
                            </label>
                        </p>

                        <p>
                            <input type="checkbox" name="signin_remember" id="api-signin-remember" @if($signinRemember) checked="checked" @endif value="1">
                            <label for="api-signin-remember" class="ckeckbox-label">
                                <span class='ui'></span>
                                @lang('content.admin.control.api.auth.remember')
                            </label>
                        </p>
                    </p>
                    <h4 class="card-title">@lang('content.admin.control.api.register.title')</h4>
                    <p class="card-text">
                    <p>
                        <input type="checkbox" name="signup_enabled" id="api-signup-enabled" @if($signupEnabled) checked="checked" @endif value="1">
                        <label for="api-signup-enabled" class="ckeckbox-label">
                            <span class='ui'></span>
                            @lang('content.admin.control.api.register.enable')
                        </label>
                    </p>
                    </p>
                </div>

                <div class="card card-block mt-2">
                    <h4 class="card-title">@lang('content.admin.control.api.sashok.title')</h4>
                    <p class="card-text">
                        <p>
                            <input type="checkbox" name="sashok_launcher_auth_enabled" id="api-sashok-launcher-auth-enabled" @if($sashokAuthEnabled) checked="checked" @endif value="1">
                            <label for="api-sashok-launcher-auth-enabled" class="ckeckbox-label">
                                <span class='ui'></span>
                                @lang('content.admin.control.api.sashok.enable')
                            </label>
                        </p>

                        <p>
                            <h4 class="card-title">@lang('content.admin.control.api.sashok.success_response.title')</h4>

                            @lang('content.admin.control.api.sashok.success_response.description')
                            <div class="md-form mt-1">
                                <i class="fa fa-commenting-o prefix"></i>
                                <input type="text" name="sashok_launcher_auth_format" id="api-sashok-launcher-format" class="form-control" value="{{ $sashokAuthFormat }}">
                                <label for="api-sashok-launcher-format">@lang('content.admin.control.api.sashok.success_response.format')</label>
                            </div>
                        </p>

                        <p>
                            <div class="md-form">
                                <i class="fa fa-exclamation-triangle prefix"></i>
                                <input type="text" name="sashok_launcher_auth_error_message" id="api-sashok-launcher-error-message" class="form-control" value="{{ $sashokAuthErrorMessage }}">
                                <label for="api-sashok-launcher-error-message">@lang('content.admin.control.api.sashok.fail_response.input')</label>
                            </div>
                        </p>

                        <p>
                            @lang('content.admin.control.api.sashok.whitelist.description')
                            <div class="md-form mt-1">
                                <i class="fa fa-sticky-note-o prefix"></i>
                                <input type="text" name="sashok_launcher_auth_white_list" id="api-sashok-launcher-white-list" class="form-control" value="{{ $sashokAuthWhiteList }}">
                                <label for="api-sashok-launcher-white-list">@lang('content.admin.control.api.sashok.whitelist.input')</label>
                            </div>
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
    </div>
@endsection
