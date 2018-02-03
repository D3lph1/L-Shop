@extends('layout.auth')

@section('title')
    @lang('content.auth.reset_password.title')
@endsection

@section('content')
    <reset-password
            access-mode-any="{{ $isAccessModeAny }}"
            access-mode-auth="{{ $isAccessModeAuth }}"
            route-login="{{ route('frontend.auth.login.render') }}"
            route-servers="{{ route('frontend.servers') }}"
            route-reset-password="{{ route('frontend.auth.password.reset.handle', ['code' => $code]) }}"
    ></reset-password>
@endsection
