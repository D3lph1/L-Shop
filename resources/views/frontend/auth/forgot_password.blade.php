@extends('layout.auth')

@section('title')
    @lang('content.auth.forgot.title')
@endsection

@section('content')
    <forgot-password
            access-mode-any="{{ $isAccessModeAny }}"
            access-mode-auth="{{ $isAccessModeAuth }}"
            route-login="{{ route('frontend.auth.login.render') }}"
            route-servers="{{ route('frontend.servers') }}"
            route-forgot-password="{{ route('frontend.auth.password.forgot.handle') }}"
            captcha="{{ $captcha }}"
    ></forgot-password>
@endsection
