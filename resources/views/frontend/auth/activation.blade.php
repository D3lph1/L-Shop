@extends('layout.auth')

@section('title')
    @lang('content.auth.activate_wait.repeat')
@endsection

@section('content')
    <activation
            access-mode-any="{{ $isAccessModeAny }}"
            access-mode-auth="{{ $isAccessModeAuth }}"
            route-login="{{ route('frontend.auth.login.render') }}"
            route-servers="{{ route('frontend.servers') }}"
            route-repeat-activation="{{ route('frontend.auth.activation.repeat') }}"
            captcha="{{ $captcha }}"
    ></activation>
@endsection
