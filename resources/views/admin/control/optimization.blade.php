{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.control.optimization.title')
@endsection

@section('content')<div id="content-container">
    <div class="z-depth-1 content-header text-center">
        <h1><i class="fa fa-leaf fa-left-big"></i>@lang('content.admin.control.optimization.title')</h1>
    </div>
    <div class="product-container">
        <form method="post" action="{{ route('admin.control.optimization.save', ['server' => $currentServer->id]) }}">
            <div class="card card-block">
                <h4 class="card-title">@lang('content.admin.control.optimization.caching.title')</h4>
                <p class="card-text">
                    <div class="md-form">
                        <i class="fa fa-clock-o prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="@lang('components.popover.title')" data-content="@lang('content.admin.control.optimization.caching.statistic_ttl_popover')"></i>
                        <input type="text" name="ttl_statistic" id="ttl-statistic" class="form-control" value="{{ $ttlStatistic }}">
                        <label for="ttl-statistic">@lang('content.admin.control.optimization.caching.statistic_ttl')</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-clock-o prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="@lang('components.popover.title')" data-content="@lang('content.admin.control.optimization.caching.pages_ttl_popover')"></i>
                        <input type="text" name="ttl_statistic_pages" id="ttl-static-pages" class="form-control" value="{{ $ttlStatiсPages }}">
                        <label for="ttl-static-pages">@lang('content.admin.control.optimization.caching.pages_ttl')</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-clock-o prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="@lang('components.popover.title')" data-content="@lang('content.admin.control.optimization.caching.news_ttl_popover')"></i>
                        <input type="text" name="ttl_news" id="ttl-news" class="form-control" value="{{ $ttlNews }}">
                        <label for="ttl-news">@lang('content.admin.control.optimization.caching.news_ttl')</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-clock-o prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="@lang('components.popover.title')" data-content="@lang('content.admin.control.optimization.caching.monitoring_ttl_popover')"></i>
                        <input type="text" name="ttl_monitoring" id="ttl-monitoring" class="form-control" value="{{ $ttlMonitoring }}">
                        <label for="ttl-news">@lang('content.admin.control.optimization.caching.monitoring_ttl')</label>
                    </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.optimization.caching.routes_cache.title')</h4>
                <p class="card-text">
                    @lang('content.admin.control.optimization.caching.routes_cache.description')
                </p>
                <div class="flex-row">
                    <a href="{{ route('admin.control.optimization.update_routes_cache', ['server' => $currentServer->id]) }}" class="btn btn-info">@lang('content.all.update')</a>
                </div>
            </div>
            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.optimization.caching.config_cache.title')</h4>
                <p class="card-text">
                    @lang('content.admin.control.optimization.caching.config_cache.description')
                </p>
                <div class="flex-row">
                    <a href="{{ route('admin.control.optimization.update_config_cache', ['server' => $currentServer->id]) }}" class="btn btn-info">@lang('content.all.update')</a>
                </div>
            </div>
            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.optimization.caching.templates_cache.title')</h4>
                <p class="card-text">
                    @lang('content.admin.control.optimization.caching.templates_cache.description')
                </p>
                <div class="flex-row">
                    <a href="{{ route('admin.control.optimization.clear_view_cache', ['server' => $currentServer->id]) }}" class="btn btn-info">@lang('content.all.clear')</a>
                </div>
            </div>
            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.optimization.caching.app_cache.title')</h4>
                <p class="card-text">
                    @lang('content.admin.control.optimization.caching.app_cache.description')
                </p>
                <div class="flex-row">
                    <a href="{{ route('admin.control.optimization.clear_app_cache', ['server' => $currentServer->id]) }}" class="btn btn-info">@lang('content.all.clear')</a>
                </div>
            </div>

            <div class="card card-block mt-5">
                <div class="flex-row">
                    {{ csrf_field() }}
                    <button class="btn btn-info">@lang('content.admin.save')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
