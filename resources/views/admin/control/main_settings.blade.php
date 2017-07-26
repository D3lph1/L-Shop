{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.control.main_settings.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-wrench fa-left-big"></i>@lang('content.admin.control.main_settings.title')</h1>
        </div>
        <form method="post" action="{{ route('admin.control.main_settings.save', ['server' => $currentServer->id]) }}">
            <div class="card card-block">
                <h4 class="card-title">@lang('content.admin.control.main_settings.shop.title')</h4>
                <p class="card-text">
                    @lang('content.admin.control.main_settings.shop.edit_info')
                    <div class="md-form mt-1">
                        <i class="fa fa-font prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="@lang('components.popover.title')" data-content="@lang('content.admin.control.main_settings.shop.name_popover')"></i>
                        <input type="text" name="shop_name" id="m-s-shop-name" class="form-control" value="{{ $shopName }}">
                        <label for="m-s-shop-name">@lang('content.admin.control.main_settings.shop.name')</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-pencil prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="@lang('components.popover.title')" data-content="@lang('content.admin.control.main_settings.shop.description_popover')"></i>
                        <textarea type="text" name="shop_description" id="m-s-shop-description" class="md-textarea">{{ $shopDescription }}</textarea>
                        <label for="m-s-shop-description">@lang('content.admin.control.main_settings.shop.description')</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-pencil prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="@lang('components.popover.title')" data-content="@lang('content.admin.control.main_settings.shop.keywords_popover')"></i>
                        <textarea type="text" name="shop_keywords" id="m-s-shop-keywords" class="md-textarea">{{ $shopKeywords }}</textarea>
                        <label for="m-s-shop-keywords">@lang('content.admin.control.main_settings.shop.keywords')</label>
                    </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.main_settings.access_mode.title')</h4>
                <p class="card-text">
                    @lang('content.admin.control.main_settings.access_mode.description')
                </p>
                <div class="flex-row">
                    <div class="btn-group mt-1 mb-1">
                        <button class="btn btn-info dropdown-toggle" id="access-mode" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($accessMode == 'guest')
                                @lang('content.admin.control.main_settings.access_mode.guest')
                            @elseif($accessMode == 'auth')
                                @lang('content.admin.control.main_settings.access_mode.auth')
                            @else
                                @lang('content.admin.control.main_settings.access_mode.all')
                            @endif
                        </button>

                        <div class="dropdown-menu">
                            <a class="dropdown-item access-mode-item change" data-parent="access-mode" data-value="guest">@lang('content.admin.control.main_settings.access_mode.guest')</a>
                            <a class="dropdown-item access-mode-item change" data-parent="access-mode" data-value="auth">@lang('content.admin.control.main_settings.access_mode.auth')</a>
                            <a class="dropdown-item access-mode-item change" data-parent="access-mode" data-value="any">@lang('content.admin.control.main_settings.access_mode.all')</a>
                        </div>
                        <input type="hidden" name="access_mode" id="access-mode-input" value="{{ $accessMode }}">
                    </div>
                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.main_settings.register.title')</h4>
                <p class="card-text"></p>
                <div class="flex-row">
                    <p>
                        <p>
                            <input type="checkbox" name="enable_signup" id="m-s-enable-signin" @if($enableSignup) checked="checked" @endif value="1">
                            <label for="m-s-enable-signin" class="ckeckbox-label">
                                <span class='ui'></span>
                                @lang('content.admin.control.main_settings.register.enable')
                            </label>
                        </p>
                        <p>
                            <input type="checkbox" name="enable_email_activation" id="m-s-enable-email-activation" @if($enableEmailActivation) checked="checked" @endif value="1">
                            <label for="m-s-enable-email-activation" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-content="Если опция включена, то после регистрации пользователю будет отправляться письмо на указанный им email. Это необходимо, дабы подтвердить валидность адреса электронной почты.">
                                <span class='ui'></span>
                                @lang('content.admin.control.main_settings.register.send_mail')
                            </label>
                        </p>
                        <p>
                            <input type="checkbox" name="signup_redirect" id="m-s-signup-redirect" @if($signupRedirect) checked="checked" @endif value="1">
                            <label for="m-s-signup-redirect" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-content="Если опция включена, то после регистрации пользователь будет перенаправлен на URL, который указан в поле ниже.">
                                <span class='ui'></span>
                                @lang('content.admin.control.main_settings.register.redirect')
                            </label>
                        </p>
                        <div class="md-form mt-2">
                            <i class="fa fa-link prefix"></i>
                            <input type="text" name="signup_redirect_url" id="m-s-signup-redirect-url" class="form-control" value="{{ $signupRedirectUrl }}">
                            <label for="m-s-signup-redirect-url">@lang('content.admin.control.main_settings.register.url')</label>
                        </div>
                    </p>
                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.main_settings.skins.title')</h4>
                <p class="card-text"></p>
                <div class="flex-row">
                    <p>
                    <p>
                        <input type="checkbox" name="character_skin_enabled" id="m-s-character-skin-enabled" @if($skinEnabled) checked="checked" @endif value="1">
                        <label for="m-s-character-skin-enabled" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-html="true" data-content="@lang('content.admin.control.main_settings.skins.enable_popover')">
                            <span class='ui'></span>
                            @lang('content.admin.control.main_settings.skins.enable')
                        </label>
                    </p>

                    <p>
                        <input type="checkbox" name="character_hd_skin_enabled" id="m-s-character-hd-skin-enabled" @if($hdSkinEnabled) checked="checked" @endif value="1">
                        <label for="m-s-character-hd-skin-enabled" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-html="true" data-content="@lang('content.admin.control.main_settings.skins.hd_popover')">
                            <span class='ui'></span>
                            @lang('content.admin.control.main_settings.skins.hd')
                        </label>
                    </p>

                    <div class="md-form mt-2">
                        <i class="fa fa-archive prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-html="true" data-content="@lang('content.admin.control.main_settings.skins.size_popover')"></i>
                        <input type="text" name="character_skin_max_file_size" id="m-s-character-skin-max-file-size" class="form-control" value="{{ $skinMaxFileSize }}">
                        <label for="m-s-character-skin-max-file-size">@lang('content.admin.control.main_settings.skins.size')</label>
                    </div>

                    <p class="mt-4">
                        <input type="checkbox" name="character_cloak_enabled" id="m-s-character-cloak-enabled" @if($cloakEnabled) checked="checked" @endif value="1">
                        <label for="m-s-character-cloak-enabled" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-html="true" data-content="@lang('content.admin.control.main_settings.cloaks.enable_popover')">
                            <span class='ui'></span>
                            @lang('content.admin.control.main_settings.cloaks.enable')
                        </label>
                    </p>

                    <p>
                        <input type="checkbox" name="character_hd_cloak_enabled" id="m-s-character-hd-cloak-enabled" @if($hdCloakEnabled) checked="checked" @endif value="1">
                        <label for="m-s-character-hd-cloak-enabled" class="ckeckbox-label" data-toggle="popover" data-placement="top" data-trigger="hover" title="Подсказка" data-html="true" data-content="@lang('content.admin.control.main_settings.cloaks.hd_popover')">
                            <span class='ui'></span>
                            @lang('content.admin.control.main_settings.cloaks.hd')
                        </label>
                    </p>

                    <div class="md-form mt-2">
                        <i class="fa fa-archive prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-html="true" data-content="@lang('content.admin.control.main_settings.cloaks.size_popover')"></i>
                        <input type="text" name="character_cloak_max_file_size" id="m-s-character-cloak-max-file-size" class="form-control" value="{{ $cloakMaxFileSize }}">
                        <label for="m-s-character-cloak-max-file-size">@lang('content.admin.control.main_settings.cloaks.size')</label>
                    </div>
                    </p>
                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.main_settings.news.title')</h4>
                <p class="card-text mt-1">
                    <input type="checkbox" name="news_enabled" id="m-s-news-enabled" @if($enableNews) checked="checked" @endif value="1">
                    <label for="m-s-news-enabled" class="ckeckbox-label">
                        <span class='ui'></span>
                        @lang('content.admin.control.main_settings.news.enable')
                    </label>
                    <div class="md-form mt-1">
                        <i class="fa fa-cubes prefix"></i>
                        <input type="text" name="news_first_portion" id="m-s-news-first-portion" class="form-control" value="{{ $newsFirstPortion }}">
                        <label for="m-s-news-first-portion">@lang('content.admin.control.main_settings.news.first_portion')</label>
                    </div>
                    <div class="md-form mt-1">
                        <i class="fa fa-cubes prefix"></i>
                        <input type="text" name="news_per_page" id="m-s-news-per-page" class="form-control" value="{{ $newsPerPage }}">
                        <label for="m-s-news-per-page">@lang('content.admin.control.main_settings.news.load_portion')</label>
                    </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Пагинация</h4>
                <p class="card-text">
                    <div class="md-form mt-1">
                        <i class="fa fa-cubes prefix"></i>
                        <input type="text" name="products_per_page" id="m-s-products-per-page" class="form-control" value="{{ $productsPerPage }}">
                        <label for="m-s-products-per-page">@lang('content.admin.control.main_settings.pagination.shop_products_per_page')</label>
                    </div>
                    <div class="md-form mt-1">
                        <i class="fa fa-cubes prefix"></i>
                        <input type="text" name="payments_per_page" id="m-s-payments-per-page" class="form-control" value="{{ $paymentsPerPage }}">
                        <label for="m-s-payments-per-page">@lang('content.admin.control.main_settings.pagination.profile_payments_per_page')</label>
                    </div>
                    <div class="md-form mt-1">
                        <i class="fa fa-cubes prefix"></i>
                        <input type="text" name="cart_per_page" id="m-s-cart-per-page" class="form-control" value="{{ $cartPerPage }}">
                        <label for="m-s-cart-per-page">@lang('content.admin.control.main_settings.pagination.profile_in_game_cart_per_page')</label>
                    </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.main_settings.shop.title')</h4>
                <p class="card-text">
                @lang('content.admin.control.main_settings.shop.sort_attr')
                <div class="btn-group mb-1">
                    <button class="btn btn-info dropdown-toggle" id="products-sort-type" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if($productsSortType === 'name')
                            @lang('content.admin.control.main_settings.shop.sort_attr_name')
                        @elseif($productsSortType === 'name_desc')
                            @lang('content.admin.control.main_settings.shop.sort_attr_name_desc')
                        @elseif($productsSortType === 'priority')
                            @lang('content.admin.control.main_settings.shop.sort_attr_sort_priority')
                        @elseif($productsSortType === 'priority_desc')
                            @lang('content.admin.control.main_settings.shop.sort_attr_sort_priority_desc')
                        @endif
                    </button>

                    <div class="dropdown-menu">
                        <a class="dropdown-item products-sort-type-item change" data-parent="products-sort-type" data-value="name">@lang('content.admin.control.main_settings.shop.sort_attr_name')</a>
                        <a class="dropdown-item products-sort-type-item change" data-parent="products-sort-type" data-value="name_desc">@lang('content.admin.control.main_settings.shop.sort_attr_name_desc')</a>
                        <a class="dropdown-item products-sort-type-item change" data-parent="products-sort-type" data-value="priority">@lang('content.admin.control.main_settings.shop.sort_attr_sort_priority')</a>
                        <a class="dropdown-item products-sort-type-item change" data-parent="products-sort-type" data-value="priority_desc">@lang('content.admin.control.main_settings.shop.sort_attr_sort_priority_desc')</a>
                    </div>
                    <input type="hidden" name="products_sort_type" id="products-sort-type-input" value="{{ $productsSortType }}">
                </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.main_settings.cart.title')</h4>
                <p class="card-text">

                <div class="md-form mt-1">
                    <i class="fa fa-cubes prefix"></i>
                    <input type="text" name="cart_capacity" id="m-s-cart-capacity" class="form-control" value="{{ $cartCapacity }}">
                    <label for="m-s-cart-capacity">@lang('content.admin.control.main_settings.cart.capacity')</label>
                </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.main_settings.monitoring.title')</h4>
                <p class="card-text"></p>
                <div class="flex-row">
                    <p>
                    <p>
                        <input type="checkbox" name="enable_monitoring" id="m-s-enable-monitoring" @if($enableMonitoring) checked="checked" @endif value="1">
                        <label for="m-s-enable-monitoring" class="ckeckbox-label">
                            <span class='ui'></span>
                            @lang('content.admin.control.main_settings.monitoring.enable')
                        </label>
                    </p>

                    <p>
                        <div class="md-form mt-2">
                            <i class="fa fa-clock-o prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-html="true" data-content="@lang('content.admin.control.main_settings.monitoring.timeout_popover')"></i>
                            <input type="text" name="rcon_connection_timeout" id="m-s-rcon-connection-timeout" class="form-control" value="{{ $rconConnectionTimeout }}">
                            <label for="m-s-rcon-connection-timeout">@lang('content.admin.control.main_settings.monitoring.timeout')</label>
                        </div>
                    </p>
                    </p>
                </div>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">@lang('content.admin.control.main_settings.maintenance.title')</h4>
                <p class="card-text">
                    @lang('content.admin.control.main_settings.maintenance.description')
                </p>
                <div class="flex-row">
                    <p>
                        <input type="checkbox" name="maintenance" id="m-s-maintenance" @if($isDownForMaintenance) checked="checked" @endif value="1">
                        <label for="m-s-maintenance" class="ckeckbox-label">
                            <span class='ui'></span>
                            @lang('content.admin.control.main_settings.maintenance.enable')
                        </label>
                    </p>
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
@endsection
