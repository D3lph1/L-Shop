{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Гайд по интеграции Sashok724's Launcher
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-link fa-left-big"></i> Гайд по интеграции Sashok724's Launcher</h1>
        </div>
        <div class="card card-block">
            <h3 class="card-title">Введение</h3>
            <p class="card-text">
                Используете лаунчер "Сашка" и желаете подключить его к L-Shop? Не вопрос! Все необходимое для этого уже
                "вшито" в магазин.
            </p>
            <h3 class="card-title">Аутентификация</h3>
            <p class="card-text">
                Для того чтобы пользователи могли играть на серверах под учетными записями, хранящимися в базе данных
                L-Shop, вам необходимо настроить аутентификацию. Лунчсервер будет производить запрос к L-Shop,
                тот будет проверять, верно ли ввел данные пользователь и отдавать ответ.
            </p>
            <h4 class="card-title">Настройка лаунчсервера</h4>
            <p class="card-text">
                Открываем файл <code>LaunchServer.cfg</code> и редактируем его следующим образом:
<pre class="json"><code>
# Auth handler
authHandler: "mysql";
authHandlerConfig: {
	fetchAll: true; # Загрузить всю базу в кэш при запуске

	address: "127.0.0.1"; # Адрес MySQL-сервера
	port: 3306; # Порт MySQL-сервера (по умолчанию 3306)
	username: "root"; # Имя пользователя MySQL-сервера
	password: ""; # Пароль пользователя
	database: "l_shop"; # База данных

	table: "lshop_users"; # Таблица с пользователями
	uuidColumn: "uuid"; # Поле с UUID пользователей
	usernameColumn: "username"; # Поле с именами пользователей
	accessTokenColumn: "accessToken"; # Поле с accessToken
	serverIDColumn: "serverID"; # Поле с serverID
};

# Auth provider
authProvider: "request";
authProviderConfig: {
	url: "http://l-shop.ru/api/launcher/sashok/auth?username=%login%&password=%password%"; # Url по которому будет идти обращение к L-Shop для проверки введенных данных, введенных пользователем
	response: "OK:(?&lt;username&gt;.+)"; # Формат ответа
};
</code></pre>
            </p>
            <h4 class="card-title">Настройка магазина</h4>
            <p class="card-text">
                Переходим в <strong>Администрирование > Управление > API</strong>, листаем ниже, находим блок "Интеграция с Sashok724's Launcher".
                Активируем функцию. Если необходимо, меняем формат успешного ответа (тогда вам потрубеутся изменить параметр authProviderConfig.response в <code>LaunchServer.cfg</code>).
                По желанию вы можете указать список разрешенных IP адресов. Мы рекомендуем делать это обязательно.
                <p>На этом интеграция закончена. Можете запустить лаунчесервер и проверить.</p>
            </p>
        </div>
    </div>
@endsection
