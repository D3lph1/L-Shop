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
