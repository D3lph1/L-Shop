@extends('layout.auth')

@section('title')
    @lang('content.auth.servers.title')
@endsection

@section('content')
    <select-server
            :servers="{{ json_encode($servers) }}"
            is-auth="{{ $isAuth }}"
            allow-login="{{ $allowLogin }}"
            route-login="{{ route('frontend.auth.login.handle') }}"
            route-logout="{{ route('frontend.auth.logout') }}"
    ></select-server>
@endsection
