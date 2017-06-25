{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Основные настройки
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-wrench fa-left-big"></i>Основные настройки</h1>
        </div>
        <form method="post" action="{{ route('admin.control.main_settings.save', ['server' => $currentServer->id]) }}">
            <div class="card card-block">
                <h4 class="card-title">Магазин</h4>
                <p class="card-text">
                    Редактировать основную информацию о магазине.
                    <div class="md-form mt-1">
                        <i class="fa fa-font prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-content="Имя магазина будет отображаться на главной страницы а также в заголовках страниц."></i>
                        <input type="text" name="shop_name" id="m-s-shop-name" class="form-control" value="{{ $shopName }}">
                        <label for="m-s-shop-name">Имя магазина</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-pencil prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-content="Описание магазина используется в основном поисковыми системами для индексации ресурса."></i>
                        <textarea type="text" name="shop_description" id="m-s-shop-description" class="md-textarea">{{ $shopDescription }}</textarea>
                        <label for="m-s-shop-description">Описание магазина</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-pencil prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-content="Ключевые слова используются в основном поисковыми системами для индексации ресурса. Их нужно перечислять через запятую без пробелов."></i>
                        <textarea type="text" name="shop_keywords" id="m-s-shop-keywords" class="md-textarea">{{ $shopKeywords }}</textarea>
                        <label for="m-s-shop-keywords">Ключевые слова</label>
                    </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Режим доступа</h4>
                <p class="card-text">
                    Этот параметр регулирует то, каким образом пользователи смогут получать доступ к магазину.<br>
                    <strong>Только гости</strong>: авторизация в магазине отключена, пользователи будут приобретать товары без входа в аккаунт.<br>
                    <strong>Только авторизованные пользователи</strong>: авторизация в магазине является обязательной, товары могут преобретать
                    только пользователи, вошедшие в свой аккаунт.<br>
                        <strong>И гости и авторизованные пользователи</strong>: Пользователи могут совершать покупки как войдя в аккаунт, так и
                    без входа в него.
                </p>
                <div class="flex-row">
                    <div class="btn-group mt-1 mb-1">
                        <button class="btn btn-info dropdown-toggle" id="access-mode" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($accessMode == 'guest')
                                Только гости
                            @elseif($accessMode == 'auth')
                                Только авторизованные пользователи
                            @else
                                И гости и авторизованные пользователи
                            @endif
                        </button>

                        <div class="dropdown-menu">
                            <a class="dropdown-item access-mode-item change" data-parent="access-mode" data-value="guest">Только гости</a>
                            <a class="dropdown-item access-mode-item change" data-parent="access-mode" data-value="auth">Только авторизованные пользователи</a>
                            <a class="dropdown-item access-mode-item change" data-parent="access-mode" data-value="any">И гости и авторизованные пользователи</a>
                        </div>
                        <input type="hidden" name="access_mode" id="access-mode-input" value="{{ $accessMode }}">
                    </div>
                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Регистрация</h4>
                <p class="card-text"></p>
                <div class="flex-row">
                    <p>
                        <p>
                            <input type="checkbox" name="enable_signup" id="m-s-enable-signin" @if($enableSignup) checked="checked" @endif value="1">
                            <label for="m-s-enable-signin" class="ckeckbox-label">
                                <span class='ui'></span>
                                Разрешить регистрацию новых пользователей
                            </label>
                        </p>
                        <p>
                            <input type="checkbox" name="enable_email_activation" id="m-s-enable-email-activation" @if($enableEmailActivation) checked="checked" @endif value="1">
                            <label for="m-s-enable-email-activation" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-content="Если опция включена, то после регистрации пользователю будет отправляться письмо на указанный им email. Это необходимо, дабы подтвердить валидность адреса электронной почты.">
                                <span class='ui'></span>
                                Включить отправку писем на почту пользователям для подтверждения аккаунта
                            </label>
                        </p>
                        <p>
                            <input type="checkbox" name="signup_redirect" id="m-s-signup-redirect" @if($signupRedirect) checked="checked" @endif value="1">
                            <label for="m-s-signup-redirect" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-content="Если опция включена, то после регистрации пользователь будет перенаправлен на URL, который указан в поле ниже.">
                                <span class='ui'></span>
                                Перенаправлять пользователя на кастомный URL после регистрации
                            </label>
                        </p>
                        <div class="md-form mt-2">
                            <i class="fa fa-link prefix"></i>
                            <input type="text" name="signup_redirect_url" id="m-s-signup-redirect-url" class="form-control" value="{{ $signupRedirectUrl }}">
                            <label for="m-s-signup-redirect-url">Кастомный URL</label>
                        </div>
                    </p>
                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Скины и плащи</h4>
                <p class="card-text"></p>
                <div class="flex-row">
                    <p>
                    <p>
                        <input type="checkbox" name="character_skin_enabled" id="m-s-character-skin-enabled" @if($skinEnabled) checked="checked" @endif value="1">
                        <label for="m-s-character-skin-enabled" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-html="true" data-content="Игроки смогут устанавливать <strong>скины</strong> для своих персонажей. Если отключена возможность установки HD скинов, то размер скина должен быть равен <strong>64x32</strong> пикселя.">
                            <span class='ui'></span>
                            Разрешить пользователям устанавливать скины
                        </label>
                    </p>

                    <p>
                        <input type="checkbox" name="character_hd_skin_enabled" id="m-s-character-hd-skin-enabled" @if($hdSkinEnabled) checked="checked" @endif value="1">
                        <label for="m-s-character-hd-skin-enabled" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-html="true" data-content="Игроки смогут устанавливать <strong>HD скины</strong> для воих персонажей. Максимадьный размер изображения - <strong>1024x512</strong>.">
                            <span class='ui'></span>
                            Разрешить пользователям устанавливать HD скины
                        </label>
                    </p>

                    <div class="md-form mt-2">
                        <i class="fa fa-archive prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-html="true" data-content="Размер следует указывать в <strong>килобайтах</strong>."></i>
                        <input type="text" name="character_skin_max_file_size" id="m-s-character-skin-max-file-size" class="form-control" value="{{ $skinMaxFileSize }}">
                        <label for="m-s-character-skin-max-file-size">Максимальный размер файла скина</label>
                    </div>

                    <p class="mt-4">
                        <input type="checkbox" name="character_cloak_enabled" id="m-s-character-cloak-enabled" @if($cloakEnabled) checked="checked" @endif value="1">
                        <label for="m-s-character-cloak-enabled" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-html="true" data-content="Игроки смогут устанавливать <strong>плащи</strong> для своих персонажей. Если отключена возможность установки HD плащей, то размер скина должен быть равен <strong>22x17</strong> пикселей.">
                            <span class='ui'></span>
                            Разрешить пользователям устанавливать плащи
                        </label>
                    </p>

                    <p>
                        <input type="checkbox" name="character_hd_cloak_enabled" id="m-s-character-hd-cloak-enabled" @if($hdCloakEnabled) checked="checked" @endif value="1">
                        <label for="m-s-character-hd-cloak-enabled" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-html="true" data-content="Игроки смогут устанавливать <strong>HD плащи</strong> для воих персонажей. Максимадьный размер изображения - <strong>1024x512</strong>.">
                            <span class='ui'></span>
                            Разрешить пользователям устанавливать HD плащи
                        </label>
                    </p>

                    <div class="md-form mt-2">
                        <i class="fa fa-archive prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-html="true" data-content="Размер следует указывать в <strong>килобайтах</strong>."></i>
                        <input type="text" name="character_cloak_max_file_size" id="m-s-character-cloak-max-file-size" class="form-control" value="{{ $cloakMaxFileSize }}">
                        <label for="m-s-character-cloak-max-file-size">Максимальный размер файла плаща</label>
                    </div>
                    </p>
                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Новости</h4>
                <p class="card-text mt-1">
                    <input type="checkbox" name="news_enabled" id="m-s-news-enabled" @if($enableNews) checked="checked" @endif value="1">
                    <label for="m-s-news-enabled" class="ckeckbox-label">
                        <span class='ui'></span>
                        Включить показ новостей
                    </label>
                    <div class="md-form mt-1">
                        <i class="fa fa-cubes prefix"></i>
                        <input type="text" name="news_first_portion" id="m-s-news-first-portion" class="form-control" value="{{ $newsFirstPortion }}">
                        <label for="m-s-news-first-portion">Количество новостей, находящихся на экране при загрузке</label>
                    </div>
                    <div class="md-form mt-1">
                        <i class="fa fa-cubes prefix"></i>
                        <input type="text" name="news_per_page" id="m-s-news-per-page" class="form-control" value="{{ $newsPerPage }}">
                        <label for="m-s-news-per-page">Количество подгружаемых за раз новостей</label>
                    </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Пагинация</h4>
                <p class="card-text">
                    <div class="md-form mt-1">
                        <i class="fa fa-cubes prefix"></i>
                        <input type="text" name="products_per_page" id="m-s-products-per-page" class="form-control" value="{{ $productsPerPage }}">
                        <label for="m-s-products-per-page">Количество товаров на 1 странице магазина</label>
                    </div>
                    <div class="md-form mt-1">
                        <i class="fa fa-cubes prefix"></i>
                        <input type="text" name="payments_per_page" id="m-s-payments-per-page" class="form-control" value="{{ $paymentsPerPage }}">
                        <label for="m-s-payments-per-page">Количество элементов на 1 странице истории платежей в профиле пользователя</label>
                    </div>
                    <div class="md-form mt-1">
                        <i class="fa fa-cubes prefix"></i>
                        <input type="text" name="cart_per_page" id="m-s-cart-per-page" class="form-control" value="{{ $cartPerPage }}">
                        <label for="m-s-cart-per-page">Количество элементов на 1 странице внутриигровой корзины в профиле пользователя</label>
                    </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Магазин</h4>
                <p class="card-text">
                Сортировать товары по:
                <div class="btn-group mb-1">
                    <button class="btn btn-info dropdown-toggle" id="products-sort-type" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if($productsSortType === 'name')
                            Названию предмета (А -> Я)
                        @elseif($productsSortType === 'name_desc')
                            Названию предмета (Я -> А)
                        @elseif($productsSortType === 'priority')
                            Приоритету сортировки товара (1 -> N)
                        @elseif($productsSortType === 'priority_desc')
                            Приоритету сортировки товара (N -> 1)
                        @endif
                    </button>

                    <div class="dropdown-menu">
                        <a class="dropdown-item products-sort-type-item change" data-parent="products-sort-type" data-value="name">Названию предмета (А -> Я)</a>
                        <a class="dropdown-item products-sort-type-item change" data-parent="products-sort-type" data-value="name_desc">Названию предмета (Я -> А)</a>
                        <a class="dropdown-item products-sort-type-item change" data-parent="products-sort-type" data-value="priority">Приоритету сортировки товара (1 -> N)</a>
                        <a class="dropdown-item products-sort-type-item change" data-parent="products-sort-type" data-value="priority_desc">Приоритету сортировки товара (N -> 1)</a>
                    </div>
                    <input type="hidden" name="products_sort_type" id="products-sort-type-input" value="{{ $productsSortType }}">
                </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Корзина</h4>
                <p class="card-text">

                <div class="md-form mt-1">
                    <i class="fa fa-cubes prefix"></i>
                    <input type="text" name="cart_capacity" id="m-s-cart-capacity" class="form-control" value="{{ $cartCapacity }}">
                    <label for="m-s-cart-capacity">Максимальная вместимость корзины</label>
                </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Мониторинг</h4>
                <p class="card-text"></p>
                <div class="flex-row">
                    <p>
                    <p>
                        <input type="checkbox" name="enable_monitoring" id="m-s-enable-monitoring" @if($enableMonitoring) checked="checked" @endif value="1">
                        <label for="m-s-enable-monitoring" class="ckeckbox-label">
                            <span class='ui'></span>
                            Включить мониторинг серверов
                        </label>
                    </p>

                    <p>
                        <div class="md-form mt-2">
                            <i class="fa fa-clock-o prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-html="true" data-content="Время, после которого произойдет автоматическое отключение соединения с сокетом сервера. (Если не произошло соединение). Указывать следует в секундах."></i>
                            <input type="text" name="rcon_connection_timeout" id="m-s-rcon-connection-timeout" class="form-control" value="{{ $rconConnectionTimeout }}">
                            <label for="m-s-rcon-connection-timeout">Таймаут соединения</label>
                        </div>
                    </p>
                    </p>
                </div>
            </div>

            <div class="card card-block mt-2">                <h4 class="card-title">Режим обслуживания</h4>
                <p class="card-text">
                    Включить / отключить режим обслуживания. Этот режим закрывает доступ к сайту.
                    Доступ будет открыт только для администраторов. Также будет доступна страница авторизации
                    (Список доступных маршрутов вы можете изменить в свойстве <code>except</code>
                    посредника <code>App\Http\Middleware\CheckForMaintenanceMode</code>).
                    При этом, всем, кто вошел на сайт, будет показано какое либо сообщение. Изменить его вы
                    можете в файле <code>resources/view/errors/503.blade.php</code>
                </p>
                <div class="flex-row">
                    <p>
                        <input type="checkbox" name="maintenance" id="m-s-maintenance" @if($isDownForMaintenance) checked="checked" @endif value="1">
                        <label for="m-s-maintenance" class="ckeckbox-label">
                            <span class='ui'></span>
                            Включить режим обслуживания
                        </label>
                    </p>
                </div>
            </div>

            <div class="card card-block mt-5">
                <div class="flex-row">
                    {{ csrf_field() }}
                    <button class="btn btn-info">Сохранить изменения</button>
                </div>
            </div>
        </form>
    </div>
@endsection
