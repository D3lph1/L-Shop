{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.profile.fillupbalance.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1  content-header text-center">
            <h1><i class="fa fa-credit-card fa-left-big"></i>@lang('content.profile.fillupbalance.title')</h1>
        </div>
        <div id="p-login">
            <div class="md-form">
                <i class="fa fa-money prefix"></i>
                <input type="text" id="fub-input" class="form-control">
                <label for="fub-input">@lang('content.profile.fillupbalance.sum')</label>
            </div>
        </div>
        <div id="content-container" class="flex-first flex">
            {!! \ReCaptcha::render() !!}
            <a class="btn btn-warning btn-lg btn-block" id="fub-btn">@lang('content.profile.fillupbalance.pay')</a>
        </div>
    </div>
@endsection
