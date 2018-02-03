@extends('layout.auth')

@section('title')
    @lang('content.auth.signin.title')
@endsection

@section('content')
    <login
            only-for-admins="{{ false }}"
            down-for-maintenance="{{ $isDownForMaintenance }}"
            enable-password-reset="{{ $isEnabledPasswordReset }}"
            route-forgot="{{ route('frontend.auth.password.forgot.render') }}"
            enable-register="{{ $isEnabledRegister }}"
            route-login="{{ route('frontend.auth.login.handle') }}"
            route-register="{{ route('frontend.auth.register.render') }}"
            access-mode-any="{{  $isAccessModeAny }}"
            route-servers="{{ route('frontend.servers') }}"
    ></login>
@endsection
