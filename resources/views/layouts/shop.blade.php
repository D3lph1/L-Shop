@extends('layouts.global')

@section('content_global')
    <div id="side-content" class="z-depth-2">
        <div id="sidebar" style="position: relative;">
            <span id="server-id" style="display: none">{{ $currentServer->id }}</span>
            @if(is_auth())
                <p id="name">{{ $username }}</p>
                <div id="profile-block">
                    <p id="balance"><i class="fa fa-database fa-left"></i>Баланс:
                        <span>{{ $balance }}
                            <i class="fa fa-dollar"></i>
                        </span>
                    </p>
                    <p id="cart"><i class="fa fa-cube fa-left"></i>Корзина: <span>7</span></p>
                    <!--<p id="rank"><i class="fa fa-star fa-left"></i>Ранг: <span>Beginner</span></p>-->
                    <button class="btn info-color btn-block"><i class="fa fa-plus fa-left fa-lg"></i>
                        <a class="white-text" href="#">Пополнить</a>
                    </button>
                    <button class="btn btn-warning btn-block"><i class="fa fa-shopping-cart fa-left fa-lg"></i>
                        Корзина
                    </button>
                    <a href="/logout" class="btn danger-color btn-block"><i class="fa fa-times fa-left fa-lg"></i>Выйти</a>
                </div>
            @endif
            @if(!is_auth())
                <div id="profile-block">
                    <p id="cart"><i class="fa fa-cube fa-left"></i>Корзина: <span>7</span></p>
                    <button class="btn btn-warning btn-block"><i class="fa fa-shopping-cart fa-left fa-lg"></i>
                        Корзина
                    </button>
                </div>
            @endif
            <div id="server-block">
                <button id="chose-server" class="btn btn-warning btn-block">
                    <i class="fa fa-chevron-left fa-left left"></i>Серверы
                </button>
                <ul id="server-list" class="servers text-left">
                    @foreach($servers as $server)
                        <li class="waves-effect"><a class="white-text" href="#">{{ $server->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div id="content">
        <div id="topbar" class="z-depth-1">
            <span id="topbar-server">Текущий сервер: <span id="tbs-name">{{ $currentServer->name }}</span></span>
        </div>

        @yield('content')

        <div id="footer">
            <div id="f-first">
                <p>2017<i class="fa fa-copyright fa-left fa-right"></i>Copyright : {{ $shopName }}</p>
            </div>
            <div id="f-second">
                <button class="btn unique-color"><i class="fa fa-vk fa-lg fa-left"></i>Vkontakte</button>
                <button class="btn btn-info"><i class="fa fa-bug fa-lg fa-left"></i>Support</button>
            </div>
        </div>
    </div>
@endsection