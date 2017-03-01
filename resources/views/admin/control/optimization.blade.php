@extends('layouts.shop')

@section('title')
    Оптимизация
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-leaf fa-left-big"></i>Оптимизация</h1>
        </div>
        <div class="card card-block">
            <h4 class="card-title">Обновить кэш маршрутов</h4>
            <p class="card-text">
                Описание маршрутов, по которым система определяет какой действие ассоциировать с тем или иным url'ом
                разбросаны по файлом и представлены в удобочитаемом для человека формате. Обновление кэша маршрутов
                позволяет сгенерировать файл, в котором будут храниться маршруты в "удобном" для системы виде и, тем
                самым, ускорить выполнение запросов.
            </p>
            <div class="flex-row">
                <form method="post" action="{{ route('admin.control.optimization.update_routes_cache', ['server' => $currentServer]) }}">
                    {{ csrf_field() }}
                    <button class="btn btn-info">Обновить</button>
                </form>
            </div>
        </div>
        <div class="card card-block mt-2">
            <h4 class="card-title">Обновить кэш конфигурации</h4>
            <p class="card-text">
                Для повышения скорости работы, Laravel кэширует настройки. После нажатия на кнопку ниже, кэш будет удален,
                а затем сгенерирован снова. Это функция может быть полезна, если вы изменили значения каких-либо
                настроек в файлах конфигурации.
            </p>
            <div class="flex-row">
                <form method="post" action="{{ route('admin.control.optimization.update_config_cache', ['server' => $currentServer]) }}">
                    {{ csrf_field() }}
                    <button class="btn btn-info">Обновить</button>
                </form>
            </div>
        </div>
        <div class="card card-block mt-2">
            <h4 class="card-title">Очистить кэш шаблонизатора</h4>
            <p class="card-text">
                Фреймворк, на котором базируется L-Shop, для удобства разработки, использует шаблонизатор Blade.
                Blade кэширует представления для того, чтобы увеличить скорость работы. Вам может понадобиться очистить
                этот кэш. Он будет воссоздан после обновления каждой страницы сайта.
            </p>
            <div class="flex-row">
                <form method="post" action="{{ route('admin.control.optimization.clear_view_cache', ['server' => $currentServer]) }}">
                    {{ csrf_field() }}
                    <button class="btn btn-info">Очистить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
