### Введение

Используете лаунчер "Сашка" и желаете подключить его к L-Shop? Не вопрос! Все необходимое для этого уже
"вшито" в магазин.

### Аутентификация и скин-система

Для того чтобы пользователи могли играть на серверах под учетными записями, хранящимися в базе данных
L-Shop, вам необходимо настроить аутентификацию. Лунчсервер будет производить запрос к L-Shop,
тот будет проверять, верно ли ввел данные пользователь и отдавать ответ.

#### Настройка LaunchServer'а

* Открываем файл *LaunchServer.cfg* и редактируем его следующим образом:
```
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
	url: "http://example.com/api/launcher/sashok/auth?username=%login%&password=%password%"; # Url по которому будет идти обращение к L-Shop для проверки введенных данных, введенных пользователем
	response: "OK:(?<username>.+)"; # Формат ответа
};
# Настраиваем систему скинов и плащей
textureProvider: "request";
textureProviderConfig: {
	skinsURL: "http://example.com/img/users/skins/%username%.png"; # URL скинов
	cloaksURL: "http://example.com/img/users/cloaks/%username%.png"; # URL плащей
```

#### Настройка магазина

Переходим в *Администрирование* > *Управление* > *API*, листаем ниже, находим блок "Интеграция с Sashok724's Launcher".
Активируем функцию. Если необходимо, меняем формат успешного ответа (тогда вам потрубеутся изменить параметр authProviderConfig.response в *LaunchServer.cfg*).
По желанию вы можете указать список разрешенных IP адресов. Мы рекомендуем делать это обязательно.

На этом интеграция закончена. Можете запустить LaunchServer и проверить.
