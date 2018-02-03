@extends('layout.auth')

@section('title')
    @lang('content.auth.register.title')
@endsection

@section('content')
    <register
            route-register="{{ route('frontend.auth.register.handle') }}"
            access-mode-any="{{ $isAccessModeAny }}"
            access-mode-auth="{{ $isAccessModeAuth }}"
            route-login="{{ route('frontend.auth.login.render') }}"
            login-servers="{{ route('frontend.servers') }}"
            captcha="{{ $captcha }}"
    ></register>
@endsection
