{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.control.security.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-lock fa-left-big"></i>@lang('content.admin.control.security.title')</h1>
        </div>

        @if(config('app.debug'))
            <div class="alert alert-danger">
                <button id="admin-security-debug-alert-close" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @lang('content.admin.control.security.debug_mode_alert')
            </div>
        @endif

        <form method="post" action="{{ route('admin.control.security.save', ['currentServer' => $currentServer->id]) }}">
            <div class="card card-block">
                <h4 class="card-title">@lang('content.admin.control.security.generator.title')</h4>
                <p class="card-text">
                    <p>@lang('content.admin.control.security.generator.description_app_key')</p>
                    <div class="form-inline">
                        <input type="text" class="form-control" value="{{ $key = 'base64:' . base64_encode(str_random(32)) }}" readonly>
                        <a class="btn btn-info" onclick="prompt('Скопировать', '{{ $key }}')"><i class="fa fa-copy"></i> @lang('content.all.copy')</a>
                    </div>
                    <div class="alert alert-info">
                        @lang('content.admin.control.security.generator.description_app_key_instruction')
                    </div>
                    <div class="alert alert-warning">
                        @lang('content.admin.control.security.generator.description_app_key_notify')
                    </div>

                    <p class="mt-2">@lang('content.admin.control.security.generator.description_app_auth_key')</p>
                    <div class="form-inline">
                        <input type="text" class="form-control" value="{{ $key = str_random(32) }}" readonly>
                        <a class="btn btn-info" onclick="prompt('Скопировать', '{{ $key }}')"><i class="fa fa-copy"></i> @lang('content.all.copy')</a>
                    </div>
                    <div class="alert alert-info">
                        @lang('content.admin.control.security.generator.description_app_key')
                    </div>
                    <div class="alert alert-warning">
                        @lang('content.admin.control.security.generator.description_app_auth_key_notify')
                    </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.security.recaptcha.title')</h4>
                <p class="card-text">
                    <p>@lang('content.admin.control.security.recaptcha.description')</p>
                    <div class="md-form mt-1">
                        <i class="fa fa-google prefix"></i>
                        <input type="text" name="recaptcha_public_key" id="sec-recaptcha-public-key" class="form-control" value="{{ $recaptchaPublicKey }}">
                        <label for="sec-recaptcha-public-key">@lang('content.admin.control.security.recaptcha.public_key')</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-google prefix"></i>
                        <input type="text" name="recaptcha_secret_key" id="sec-recaptcha-secret-key" class="form-control" value="{{ $recaptchaSecretKey }}">
                        <label for="sec-recaptcha-secret-key">@lang('content.admin.control.security.recaptcha.secret_key')</label>
                    </div>
                </p>
                <div class="flex-row">
                    <a class="btn btn-info" data-toggle="modal" data-target="#recaptcha-example-modal">@lang('content.admin.control.security.recaptcha.check')</a>
                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.security.user.title')</h4>
                <p class="card-text">
                <div class="md-form mt-1">
                    <input type="checkbox" name="enable_change_password" id="enable-change-password" @if($enabledChangePassword) checked="checked" @endif value="1">
                    <label for="enable-change-password" class="ckeckbox-label">
                        <span class='ui'></span>
                        @lang('content.admin.control.security.user.allow_change_password')
                    </label>
                </div>
                <div class="md-form mt-1">
                    <input type="checkbox" name="enable_reset_password" id="enable-reset-password" @if($enabledResetPassword) checked="checked" @endif value="1">
                    <label for="enable-reset-password" class="ckeckbox-label">
                        <span class='ui'></span>
                        @lang('content.admin.control.security.user.allow_reset_password')
                    </label>
                </div>
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
    <div class="modal fade" id="recaptcha-example-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100" id="myModalLabel">@lang('content.admin.control.security.recaptcha.modal.title')</h4>
                </div>
                <div class="modal-body">
                    {!! ReCaptcha::render() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">@lang('content.admin.control.security.recaptcha.modal.btn')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
