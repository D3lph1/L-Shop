{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.global')

@section('content_global')
    <div id="side-content" class="z-depth-2">
        <div id="sidebar" style="position: relative;">
            <p id="s-btn-c">
                <button id="btn-menu-c" class="btn waves-effect"><i class="fa fa-arrow-left"></i></button>
            </p>
            @if($isAuth)
                <p id="name">{{ $username }}</p>
                <div id="profile-block">
                    <p id="balance"><i class="fa fa-database fa-left"></i>
                        Баланс:
                        <span id="balance-span">
                            {{ $balance }}
                        </span>
                            {!! $currency !!}
                    </p>
                    <!--<p id="rank"><i class="fa fa-star fa-left"></i>Ранг: <span>Beginner</span></p>-->
                    <a href="{{ $catalogUrl }}" class="btn info-color btn-block">
                        <i class="fa fa-list fa-lg fa-left"></i>
                        Каталог
                    </a>
                    <a href="{{ route('cart', ['server' => $currentServer->id]) }}" class="btn info-color btn-block">
                        <i class="fa fa-shopping-cart fa-left fa-lg"></i>
                        Корзина
                    </a>
                    <a href="{{ route('fillupbalance', ['server' => $currentServer->id]) }}" class="btn btn-warning btn-block">
                        <i class="fa fa-credit-card fa-left fa-lg"></i>
                        Пополнить
                    </a>
                    <a href="{{ $logoutUrl }}" class="btn danger-color btn-block">
                        <i class="fa fa-times fa-left fa-lg"></i>
                        Выйти
                    </a>
                </div>
            @endif
            @if(!$isAuth)
                <div id="profile-block">
                    <p id="cart">
                        <i class="fa fa-cube fa-left"></i>
                        Корзина: <span>7</span>
                    </p>
                    <a href="{{ $catalogUrl }}" class="btn info-color btn-block">
                        <i class="fa fa-list fa-lg fa-left"></i>
                        Каталог
                    </a>
                    <a href="{{ $cartUrl }}" class="btn info-color btn-block">
                        <i class="fa fa-shopping-cart fa-left fa-lg"></i>
                        Корзина
                    </a>
                    @if($canEnter)
                        <a href="{{ $signinUrl }}" class="btn btn-warning btn-block">
                            <i class="fa fa-key fa-left fa-lg"></i>
                            Войти
                        </a>
                    @endif
                </div>
            @endif
            @if($isAuth)
                <div class="l-shop-collapse">
                    <p class="a-b-header">Профиль</p>
                    <p>
                        <a href="{{ route('profile.settings', ['server' => $currentServer->id]) }}" class="btn btn-info btn-block"><i class="fa fa-gear left"></i>Настройки</a>
                    </p>
                    <div class="ad-btn-block">
                        <button class="btn btn-info btn-block admin-menu-btn"><i class="fa fa-info left"></i>Информация</button>
                        <ul class="ad-btn-list">
                            <a href="{{ route('profile.payments', ['server' => $currentServer->id]) }}" class="waves-effect">Платежи</a>
                            <a href="{{ route('profile.cart', ['server' => $currentServer->id]) }}" class="waves-effect">Внутриигровая корзина</a>
                        </ul>
                    </div>
                </div>
            @endif
            @if ($isAdmin)
                <div class="l-shop-collapse">
                    <p class="a-b-header">Администрирование</p>
                    <div class="ad-btn-block">
                        <button class="btn btn-info btn-block admin-menu-btn"><i class="fa fa-cogs left"></i>Управление</button>
                        <ul class="ad-btn-list">
                            <a href="{{ route('admin.control.main_settings', ['server' => $currentServer->id]) }}" class="waves-effect">Основные настройки</a>
                            <a href="{{ route('admin.control.payments', ['server' => $currentServer->id]) }}" class="waves-effect">Платежи</a>
                            <a href="{{ route('admin.control.api', ['server' => $currentServer->id]) }}" class="waves-effect">API</a>
                            <a href="{{ route('admin.control.security', ['server' => $currentServer->id]) }}" class="waves-effect">Безопасность</a>
                            <a href="{{ route('admin.control.optimization', ['server' => $currentServer->id]) }}" class="waves-effect">Оптимизация</a>
                        </ul>
                    </div>
                    <div class="ad-btn-block">
                        <button class="btn btn-info btn-block admin-menu-btn"><i class="fa fa-server left"></i>Серверы</button>
                        <ul class="ad-btn-list">
                            <a href="{{ route('admin.servers.add', ['server' => $currentServer->id]) }}" class="waves-effect">Добавить</a>
                            <a href="{{ route('admin.servers.list', ['server' => $currentServer->id]) }}" class="waves-effect">Редактировать</a>
                        </ul>
                    </div>
                    <div class="ad-btn-block">
                        <button class="btn btn-info btn-block admin-menu-btn"><i class="fa fa-cubes left"></i>Товары</button>
                        <ul class="ad-btn-list">
                            <a href="{{ route('admin.products.add', ['server' => $currentServer->id]) }}" class="waves-effect">Добавить</a>
                            <a href="{{ route('admin.products.list', ['server' => $currentServer->id]) }}" class="waves-effect">Редактировать</a>
                        </ul>
                    </div>
                    <div class="ad-btn-block">
                        <button class="btn btn-info btn-block admin-menu-btn"><i class="fa fa-diamond left"></i>Предметы</button>
                        <ul class="ad-btn-list">
                            <a href="{{ route('admin.items.add', ['server' => $currentServer->id]) }}" class="waves-effect">Добавить</a>
                            <a href="{{ route('admin.items.list', ['server' => $currentServer->id]) }}" class="waves-effect">Редактировать</a>
                        </ul>
                    </div>
                    <div class="ad-btn-block">
                        <button class="btn btn-info btn-block admin-menu-btn"><i class="fa fa-users left"></i>Пользователи</button>
                        <ul class="ad-btn-list">
                            <a href="{{ route('admin.users.list', ['server' => $currentServer->id]) }}" class="waves-effect">Редактировать</a>
                        </ul>
                    </div>
                    <div class="ad-btn-block">
                        <button class="btn btn-info btn-block admin-menu-btn"><i class="fa fa-ellipsis-h left"></i>Другое</button>
                        <ul class="ad-btn-list">
                            <a href="{{ route('admin.other.debug', ['server' => $currentServer->id]) }}" class="waves-effect">Отладка</a>
                        </ul>
                    </div>
                    <div class="ad-btn-block">
                        <button class="btn btn-info btn-block admin-menu-btn"><i class="fa fa-pencil left"></i>Статистика</button>
                        <ul class="ad-btn-list">
                            <a href="{{ route('admin.statistic.show', ['server' => $currentServer->id]) }}" class="waves-effect">Просмотр статистики</a>
                            <a href="{{ route('admin.statistic.payments', ['server' => $currentServer->id]) }}" class="waves-effect">Платежи</a>
                        </ul>
                    </div>
                    <div class="ad-btn-block">
                        <button class="btn btn-info btn-block admin-menu-btn"><i class="fa fa-info left"></i>Информация</button>
                        <ul class="ad-btn-list">
                            <a href="{{ route('admin.info.docs', ['server' => $currentServer->id]) }}" class="waves-effect">Документация</a>
                            <a href="{{ route('admin.info.about', ['server' => $currentServer->id]) }}" class="waves-effect">О системе L-Shop</a>
                        </ul>
                    </div>
                </div>
            @endif
            <div id="server-block">
                <button id="chose-server" class="btn btn-warning btn-block">
                    <i class="fa fa-chevron-right fa-left left"></i>Серверы
                </button>
                <div id="server-list" class="servers text-left">
                    @foreach($servers as $server)
                        @if($server->enabled or is_admin())
                            <a class="waves-effect white-text" href="{{ route('catalog', ['server' => $server->id]) }}"> @if(!$server->enabled) <i class="fa fa-power-off fa-left" title="Сервер отключен"></i> @endif {{ $server->name }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="content">
        <div id="topbar" class="z-depth-1">
            <button id="btn-menu" class="btn"><i class="fa fa-bars"></i></button>
            <a href="{{ route('servers') }}">
                <span id="topbar-server">Текущий сервер: <span id="tbs-name">{{ $currentServer->name }}</span></span>
            </a>
        </div>

        @yield('content')

        <div id="footer">
            <div id="f-first">
                <p>2017<i class="fa fa-copyright fa-left fa-right"></i>Copyright : {{ $shopName }}</p>
            </div>
            <div id="f-second">
                <a href="https://github.com/D3lph1/L-shop" target="_blank" class="btn btn-info"><i class="fa fa-github fa-lg fa-left"></i>Github</a>
            </div>
        </div>
    </div>
@endsection
