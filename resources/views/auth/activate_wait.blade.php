{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.auth')

@section('title')
    @lang('content.auth.activate_wait.title')
@endsection

@section('content')
    <div class="full-h flex-center pd-v-form">
        <div class="card no-pdh z-depth-4 col-xl-4 col-md-6 col-11">

            <form method="post" action="">
                <div class="card-block" id="sign-up">
                    <div class="card-header d_orange text-center white-text z-depth-2">
                        <h1>@lang('content.auth.activate_wait.title')<i class="fa fa-envelope-o fa-lg fa-right"></i></h1>
                    </div>
                    <div class="md-form">
                        <div class="alert alert-info">
                            @lang('content.auth.activate_wait.description')
                        </div>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-envelope fa-lg prefix"></i>
                        <input type="text" name="email" id="su-email" class="form-control">
                        <label for="su-email">@lang('content.all.email')</label>
                    </div>
                    <div class="md-form">
                        {!! \ReCaptcha::render() !!}
                    </div>
                    <div class="col-12 text-center">
                        {{ csrf_field() }}
                        <button class="btn btn-warning btn-lg" id="btn-send">@lang('content.auth.activate_wait.repeat')</button>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        @if(access_mode_any() or access_mode_auth())
                            <div class="col-12 text-center">
                                <a href="{{ route('signin') }}"><i class="fa fa-plus fa-left"></i> @lang('content.auth.signin.title')</a>
                            </div>
                        @endif
                        @if(access_mode_any())
                            <div class="col-12 text-center">
                                <a href="{{ route('servers') }}"><i class="fa fa-shopping-cart"></i> @lang('content.auth.signin.guest')</a>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
