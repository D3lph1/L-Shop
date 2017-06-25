{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Оптимизация
@endsection

@section('content')<div id="content-container">
    <div class="z-depth-1 content-header text-center">
        <h1><i class="fa fa-leaf fa-left-big"></i>Оптимизация</h1>
    </div>
    <div class="product-container">
        <form method="post" action="{{ route('admin.control.optimization.save', ['server' => $currentServer->id]) }}">
            <div class="card card-block">
                <h4 class="card-title">Кеширование</h4>
                <p class="card-text">
                    <div class="md-form">
                        <i class="fa fa-clock-o prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-content="По истечении этого времени кэш статистики магазина будет удален, а затем обновлен."></i>
                        <input type="text" name="ttl_statistic" id="ttl-statistic" class="form-control" value="{{ $ttlStatistic }}">
                        <label for="ttl-statistic">Время существования кэша статистики (минут)</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-clock-o prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-content="По истечении этого времени кэш статических страниц будет удален, а затем обновлен."></i>
                        <input type="text" name="ttl_statistic_pages" id="ttl-static-pages" class="form-control" value="{{ $ttlStatiсPages }}">
                        <label for="ttl-static-pages">Время существования кэша статических страниц (минут)</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-clock-o prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-content="По истечении этого времени кэш новостей будет удален, а затем обновлен."></i>
                        <input type="text" name="ttl_news" id="ttl-news" class="form-control" value="{{ $ttlNews }}">
                        <label for="ttl-news">Время существования кэша новостей (минут)</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-clock-o prefix" data-toggle="popover" data-placement="right" data-trigger="hover" title="Подсказка" data-content="По истечении этого времени кэш мониторинга серверов будет удален, а затем обновлен."></i>
                        <input type="text" name="ttl_monitoring" id="ttl-monitoring" class="form-control" value="{{ $ttlMonitoring }}">
                        <label for="ttl-news">Время существования кэша мониторинга серверов (минут)</label>
                    </div>
                </p>
            </div>

            <div class="card card-block mt-2">
                <h4 class="card-title">Обновить кэш маршрутов</h4>
                <p class="card-text">
                    Описание маршрутов, по которым система определяет какой действие ассоциировать с тем или иным url'ом
                    разбросаны по файлам и представлены в удобочитаемом для человека формате. Обновление кэша маршрутов
                    позволяет сгенерировать файл, в котором будут храниться маршруты в "удобном" для системы виде и, тем
                    самым, ускорить выполнение запросов.
                </p>
                <div class="flex-row">
                    <a href="{{ route('admin.control.optimization.update_routes_cache', ['server' => $currentServer->id]) }}" class="btn btn-info">Обновить</a>
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
                    <a href="{{ route('admin.control.optimization.update_config_cache', ['server' => $currentServer->id]) }}" class="btn btn-info">Обновить</a>
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
                    <a href="{{ route('admin.control.optimization.clear_view_cache', ['server' => $currentServer->id]) }}" class="btn btn-info">Очистить</a>
                </div>
            </div>
            <div class="card card-block mt-2">
                <h4 class="card-title">Очистить кэш приложения</h4>
                <p class="card-text">
                    Для достижения наилучшей производительности, L-Shop кеширует многие данные, дабы "доставать" их из
                    кеша, а не "тащить" из базы данных. Кнопка ниже поможет очистить всю эту информацию. Она будет воссоздана
                    автоматически, когда это потребуется.
                </p>
                <div class="flex-row">
                    <a href="{{ route('admin.control.optimization.clear_app_cache', ['server' => $currentServer->id]) }}" class="btn btn-info">Очистить</a>
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
</div>
@endsection
