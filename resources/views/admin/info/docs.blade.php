{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.other.info.docs.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-book fa-left-big"></i>@lang('content.admin.other.info.docs.title')</h1>
        </div>
        <div class="card card-block">
            <h4 class="card-title">@lang('content.admin.other.info.docs.main')</h4>
            <p class="card-text"></p>
            <div class="flex-row">
                <a href="{{ route('admin.info.docs.main', ['server' => $currentServer->getId()]) }}" class="btn btn-info">@lang('content.admin.other.info.docs.read')</a>
            </div>
        </div>
        <div class="card card-block mt-2">
            <h4 class="card-title">@lang('content.admin.other.info.docs.api')</h4>
            <p class="card-text"></p>
            <div class="flex-row">
                <a href="{{ route('admin.info.docs.api', ['server' => $currentServer->getId()]) }}" class="btn btn-info">@lang('content.admin.other.info.docs.read')</a>
            </div>
        </div>
        <div class="card card-block mt-2">
            <h4 class="card-title">@lang('content.admin.other.info.docs.sashok')</h4>
            <p class="card-text"></p>
            <div class="flex-row">
                <a href="{{ route('admin.info.docs.sashok_launcher_integration', ['server' => $currentServer->getId()]) }}" class="btn btn-info">@lang('content.admin.other.info.docs.read')</a>
            </div>
        </div>
        <div class="card card-block mt-2">
            <h4 class="card-title">@lang('content.admin.other.info.docs.cli')</h4>
            <p class="card-text"></p>
            <div class="flex-row">
                <a href="{{ route('admin.info.docs.cli', ['server' => $currentServer->getId()]) }}" class="btn btn-info">@lang('content.admin.other.info.docs.read')</a>
            </div>
        </div>
    </div>
@endsection
