{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.profile.settings.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-gear fa-lg fa-left-big"></i>@lang('content.profile.settings.title')</h1>
        </div>
        <div class="card card-block">
            <h3 class="card-title">@lang('content.profile.settings.security.title')</h3>
            @if($enableChangePassword)
                <form action="{{ route('profile.settings.password', ['server' => $currentServer->id]) }}" method="POST">
                    <h4 class="card-title">@lang('content.profile.settings.security.change_password')</h4>
                    <p class="card-text">
                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input type="password" name="password" id="p-password" class="form-control">
                        <label for="p-password">@lang('content.profile.settings.security.password')</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input type="password" name="password_confirmation" id="p-password-confirmation"
                               class="form-control">
                        <label for="p-password-confirmation">@lang('content.profile.settings.security.password_confirmation')</label>
                    </div>
                    </p>
                    <div class="flex-row">
                        {{ csrf_field() }}
                        <button class="btn btn-info">@lang('content.all.save')</button>
                    </div>
                </form>
            @endif
            <h4 class="card-title mt-2">@lang('content.profile.settings.sessions.title')</h4>
            <p class="card-text">
            @lang('content.profile.settings.sessions.description')
            <form action="{{ route('profile.settings.sessions', ['server' => $currentServer->id]) }}" method="POST">
                {{ csrf_field() }}
                <div class="flex-row">
                    <button class="btn danger-color">@lang('content.profile.settings.sessions.reset')</button>
                </div>
            </form>
            </p>
        </div>
    </div>
@endsection
