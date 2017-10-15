{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.payments.methods.title')
@endsection

@section('content')
    <div id="block-header" class="z-depth-1">
        <h1><i class="fa fa-credit-card fa-left-big"></i>@lang('content.payments.methods.title')</h1>
    </div>
    <div id="content-container" class="flex-first flex">
        @if($methods->getRobokassa())
            <a href="{!! $methods->getRobokassa() !!}" class="btn btn-warning btn-lg btn-block">ROBOKASSA</a>
        @endif

        @if($methods->getInterkassa())
            <a href="{!! $methods->getInterkassa() !!}" class="btn btn-warning btn-lg btn-block">INTERKASSA</a>
        @endif

        @if(!($methods->getRobokassa() or $methods->getInterkassa()))
            <div class="flex-center flex">
                <h3>@lang('content.payments.methods.nothing')</h3>
            </div>
        @endif
    </div>
@endsection
