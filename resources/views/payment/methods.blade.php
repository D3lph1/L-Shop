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
        @if($robokassa)
            <a href="{!! $robokassa !!}" class="btn btn-warning btn-lg btn-block">ROBOKASSA</a>
        @endif

        @if($interkassa)
            <a href="{!! $interkassa !!}" class="btn btn-warning btn-lg btn-block">INTERKASSA</a>
        @endif

        @if(!($robokassa or $interkassa))
            <div class="flex-center flex">
                <h3>@lang('content.payments.methods.nothing')</h3>
            </div>
        @endif
    </div>
@endsection
