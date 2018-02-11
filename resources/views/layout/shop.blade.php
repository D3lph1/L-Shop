@extends('layout.global')

@section('global')
    <div id="side-content" class="z-depth-2">
        <div id="sidebar" style="position: relative;">
            <p id="s-btn-c">
                <button id="btn-menu-c" class="btn waves-effect"><i class="fa fa-arrow-left"></i></button>
            </p>
            <profile-block
                    is-auth="{{ $isAuth }}"
                    username="{{ $username }}"
                    balance="{{ $balance }}"
                    currency="{{ $currency }}"
                    route-catalog="{{ $routeCatalog }}"
                    route-cart="{{ $routeCart }}"
                    cart-count="{{ $cartCount }}"
                    route-fillupbalance=""
                    route-logout="{{ route('frontend.auth.logout') }}"
                    can-login="{{ $canLogin }}"
                    route-login="{{ route('frontend.auth.login.render') }}"
            ></profile-block>
            @if($isAuth)
                <collapse-block
                        title="@lang('sidebar.profile.title')"
                        :items="{{ json_encode($profile) }}"
                ></collapse-block>
            @endif
            @if ($isAdmin)
                <collapse-block
                        title="@lang('sidebar.admin.title')"
                        :items="{{ json_encode($adminBlock) }}"
                ></collapse-block>
            @endif
            <servers-block
                    title="@lang('sidebar.servers')"
                    :servers="{{ json_encode($serversBlock) }}"
            ></servers-block>
        </div>
    </div>

    @if($news)
        <news-block
                :items="{{ json_encode($news) }}"
                route-load-more="{{ route('frontend.news.load') }}"
        ></news-block>
    @endif

    <div id="content">
        <div id="topbar" class="z-depth-1">
            <div class="row">
                <div class="col-8" id="topbar-content-1">
                    <button id="btn-menu" class="btn"><i class="fa fa-bars"></i></button>
                    <a href="{{ route('frontend.servers') }}">
                        <span id="topbar-server">@lang('content.shop.server_name') <span id="tbs-name">{{ $currentServerName }}</span></span>
                    </a>
                </div>

                <div class="col-4 text-right" id="topbar-content-2">
                    @if($monitoringEnabled && count($monitoredServers) > 0)
                        <button id="btn-monitoring" class="btn topbar-btn"><i class="fa fa-bar-chart"></i></button>
                    @endif
                    @if(count($news) > 0)
                        <button id="btn-news" class="btn topbar-btn"><i class="fa fa-newspaper-o"></i></button>
                    @endif
                </div>
            </div>
        </div>

        <div id="content-container">
            @yield('content')
        </div>

        <div id="footer">
            <div id="f-first">
                <p>2017-2018<i class="fa fa-copyright fa-left fa-right"></i>Copyright : {{ $shopName }}</p>
            </div>

            <div id="f-second">
                <a href="https://github.com/D3lph1/L-shop" target="_blank" class="btn btn-info"><i class="fa fa-github fa-lg fa-left"></i>Github</a>
            </div>
        </div>
    </div>
@endsection
