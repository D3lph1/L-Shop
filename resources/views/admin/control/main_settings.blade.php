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
                        <i class="fa fa-font prefix"></i>
                        <input type="text" name="shop_name" id="m-s-shop-name" class="form-control" value="{{ $shopName }}">
                        <label for="m-s-shop-name">Имя магазина</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-pencil prefix"></i>
                        <textarea type="text" name="shop_description" id="m-s-shop-description" class="md-textarea">{{ $shopDescription }}</textarea>
                        <label for="m-s-shop-description">Описание магазина</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-pencil prefix"></i>
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
                            <label for="m-s-enable-email-activation" class="ckeckbox-label">
                                <span class='ui'></span>
                                Включить отправку писем на почту пользователям для подтверждения аккаунта
                            </label>
                        </p>
                    </p>
                </div>
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
                <h4 class="card-title">Режим обслуживания</h4>
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
