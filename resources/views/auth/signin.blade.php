{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.auth')

@section('title')
    @lang('content.auth.signin.title')
@endsection

@section('content')
    <!-- Sign in user page -->
    <div class="full-h flex-center pd-v-form">
        <div class="card no-pdh z-depth-4 col-xl-4 col-md-6 col-11">

            <div class="card-block" id="sign-in" data-url="{{ route('signin') }}" data-redirect="{{ route('servers') }}">
                <div class="card-header d_orange text-center white-text z-depth-2">
                    <h1>@lang('content.auth.signin.title')<i class="fa fa-sign-in fa-lg fa-right"></i></h1>
                </div>
                @if($onlyForAdmins or $downForMaintenance)
                    <div class="alert alert-info text-center">
                        @lang('content.auth.signin.only_for_admins')
                    </div>
                @endif
                <div class="md-form">
                    <i class="fa fa-user fa-lg prefix"></i>
                    <input type="text" id="si-username" class="form-control">
                    <label for="si-username">@lang('content.all.username')</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-lock fa-lg prefix"></i>
                    <input type="password" id="si-password" class="form-control">
                    <label for="si-password">@lang('content.all.password')</label>
                </div>
                <div class="col-12 text-center">
                    <button class="btn btn-warning btn-lg" id="btn-sign-in">@lang('content.auth.signin.btn')</button>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    @if($enablePasswordReset)
                        <div class="col-12 text-center">
                            <a href="{{ route('forgot') }}"><i class="fa fa-unlock fa-left"></i> @lang('content.auth.signin.forgot')</a>
                        </div>
                    @endif
                    @if($enable_signup and !$onlyForAdmins)
                        <div class="col-12 text-center">
                            <a href="{{ route('signup') }}"><i class="fa fa-plus fa-left"></i> @lang('content.auth.signin.signup')</a>
                        </div>
                    @endif
                    @if(access_mode_any())
                        <div class="col-12 text-center">
                            <a href="{{ route('servers') }}"><i class="fa fa-shopping-cart"></i> @lang('content.auth.signin.guest')</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End -->
@endsection
