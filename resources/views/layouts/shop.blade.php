@extends('layouts.global')

@section('content_global')
    <div id="side-content" class="z-depth-2">
        <div id="sidebar" style="position: relative;">
            <p id="s-btn-c">
                <button id="btn-menu-c" class="btn waves-effect"><i class="fa fa-arrow-left"></i></button>
            </p>
            @if(is_auth())
                <p id="name">{{ \Sentinel::getUser()->getUserLogin() }}</p>
                <div id="profile-block">
                    <p id="balance"><i class="fa fa-database fa-left"></i>Баланс:
                        <span>
                            {{ \Sentinel::getUser()->getBalance() }}
                            <i class="fa fa-dollar"></i>
                        </span>
                    </p>
                    <!--<p id="rank"><i class="fa fa-star fa-left"></i>Ранг: <span>Beginner</span></p>-->
                    <a href="{{ route('catalog', ['server' => $currentServer->id]) }}" class="btn info-color btn-block">
                        <i class="fa fa-list fa-lg fa-left"></i>
                        Каталог
                    </a>
                    <a href="{{ route('cart', ['server' => $currentServer->id]) }}" class="btn info-color btn-block">
                        <i class="fa fa-shopping-cart fa-left fa-lg"></i>
                        Корзина
                    </a>
                    <button class="btn btn-warning btn-block">
                        <i class="fa fa-credit-card fa-left fa-lg"></i>
                        <a class="white-text" href="">Пополнить</a>
                    </button>
                    <a href="/logout" class="btn danger-color btn-block"><i class="fa fa-times fa-left fa-lg"></i>Выйти</a>
                </div>
            @endif
            @if(!is_auth())
                <div id="profile-block">
                    <p id="cart">
                        <i class="fa fa-cube fa-left"></i>
                        Корзина: <span>7</span>
                    </p>
                    <button class="btn btn-warning btn-block"><i class="fa fa-shopping-cart fa-left fa-lg"></i>
                        Корзина
                    </button>
                </div>
            @endif
            <div id="server-block">
                <button id="chose-server" class="btn btn-warning btn-block">
                    <i class="fa fa-chevron-left fa-left left"></i>Серверы
                </button>
                <div id="server-list" class="servers text-left">
                    @foreach($servers as $server)
                        <a class="waves-effect white-text" href="{{ route('catalog', ['server' => $server->id]) }}">{{ $server->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="content">
        <div id="topbar" class="z-depth-1">
            <button id="btn-menu" class="btn"><i class="fa fa-bars"></i></button>
            <span id="topbar-server">Текущий сервер: <span id="tbs-name">{{ $currentServer->name }}</span></span>
        </div>

        @yield('content')

        <div id="footer">
            <div id="f-first">
                <p>2017<i class="fa fa-copyright fa-left fa-right"></i>Copyright : {{ s_get('shop.name', 'L - Shop') }}</p>
            </div>
            <div id="f-second">
                <button class="btn unique-color"><i class="fa fa-vk fa-lg fa-left"></i>Vkontakte</button>
                <button class="btn btn-info"><i class="fa fa-bug fa-lg fa-left"></i>Support</button>
            </div>
        </div>
    </div>
@endsection