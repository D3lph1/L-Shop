{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
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
        <button class="btn btn-info btn-block admin-menu-btn"><i class="fa fa-files-o left"></i>Статические страницы</button>
        <ul class="ad-btn-list">
            <a href="{{ route('admin.pages.add', ['server' => $currentServer->id]) }}" class="waves-effect">Добавить</a>
            <a href="{{ route('admin.pages.list', ['server' => $currentServer->id]) }}" class="waves-effect">Редактировать</a>
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