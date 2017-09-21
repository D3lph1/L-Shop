{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.other.debug.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-free-code-camp fa-left-big"></i>@lang('content.admin.other.debug.title')</h1>
        </div>
        <div class="product-container">
            <div class="card card-block">
                <h4 class="card-title">@lang('content.admin.other.debug.mail.title')</h4>
                <p class="card-text">
                @lang('content.admin.other.debug.mail.description')
                <form method="post" action="{{ route('admin.other.test_mail', ['server' => $currentServer->getId()]) }}">
                    <div class="md-form mt-1">
                        <i class="fa fa-envelope-o prefix"></i>
                        <input type="text" name="test_mail_address" id="debug-test-mail-address" class="form-control">
                        <label for="debug-test-mail-address">@lang('content.admin.other.debug.mail.address')</label>

                        {{ csrf_field() }}
                        <button class="btn btn-info">@lang('content.admin.other.debug.mail.send')</button>
                    </div>
                    @if(\Session::has('test_mail_exception'))
                        @lang('content.admin.other.debug.mail.fail')
                        <div class="alert alert-danger mt-1" style="font-size: 80%">
                            {{ \Session::get('test_mail_exception') }}
                        </div>
                        @lang('content.admin.other.debug.mail.fail_log')
                    @endif
                </form>
                </p>
            </div>
        </div>
    </div>
@endsection