{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Основные сведения по работе с системой
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-info fa-left-big"></i>Основные сведения по работе с системой</h1>
        </div>
        <div class="card card-block">
            <h3 class="card-title">Предметы и товары</h3>
            <p class="card-text">
                <p>
                    Вы, наверное, уже заметили то, что в L-Shop присутствует такая терминология, как <strong>предмет</strong>
                    и <strong>товар</strong>. По началу, вам может показаться бессмысленным такое деление, но позже вы
                    поймете, что это очень удобно. Приведу пример.
                </p>
                <p>
                    Представьте, что у вас есть 2 сервера Vanilla и Hi-Tech. Вы захотели продавать на обоих серверах алмазы.
                    Но, как правило, алмазы на ванильном сервере являются более ценным ресурсом, нежели на высокотехнологичном
                    сервере. Следовательно, для разных серверов нужно указывать разную цену. И вот, вы создаете предмет
                    "Алмаз", загружаете ему красивую картинку, указываете ID 264. А затем, попросту, создаете 2
                    товара: 1 для Vanila, а другой - для Hi-Tech сервера, ествесственно, указывая им разную цену, а может,
                    и количество. Таким образом у вас есть 1 предмет, который вы можете привязывать к разным товарам.
                    И это действительно удобно! Если бы система состояла только из товаров, то вам бы пришлось дублировать данные
                    алмаза для каждого сервера.
                </p>
            </p>
            <h3 class="card-title mt-2">Структура L-Shop'а</h3>
            <p class="card-text">
            <p>
                Ниже будут рассмотрена структура каталогов магазина. Стоит отметить, что отбражены будут лишь
                <u>некоторые части</u>, дабы осветить лишь то, что вам может понадобится. Наведите на название папки или файла,
                чтобы увидеть описание.
            </p>
            <p>
            <p>
                <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="В этой директории хранится весь основной программный (PHP) код магазина. Это мозг L-Shop'а. Чтобы пользователь не делал в магазине, все обрабатывается именно здесь.">app</strong>
            </p>
            <p>
                <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="С этой папки начинается работа всей системы. Файлы внутри вызываются непосредственно из index.php. Также здесь хранится кэш, необходимый для более быстрого 'запуска' фреймворка.">bootstrap</strong>
            </p>
            <p>
                <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="В config находится вся конфигурация системы.">config</strong>
            </p>

                <p class="ml-3">
                    <i class="fa fa-file-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Этот файл соднржит основные настройки приложения. Нужная конфигурация автоматически подхватывается из .env, поэтому вам может понадобится редактировать этот файл только в самом крайнем случае.">app.php</strong>
                </p>
                <p class="ml-3">
                    <i class="fa fa-file-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Файл с 'техническими' настройками магазина. Способствует более тонкой настройки L-Shop'а.">l-shop.php</strong>
                </p>

            <p>
                <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Директория database содержит данные, необходимые для миграции, заполнения базы данных.">database</strong>
            </p>

                <p class="ml-3">
                    <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Как правило здесь хранится один единственный файл с дампом таблиц 'dump.sql', однако папка также может содержать различные версии этого файла.">dump</strong>
                </p>
                    <p class="ml-5">
                        <i class="fa fa-file-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Этот файл необходимо импортировать в вашу базу данных, он хранит схему, а также содержимое таблиц.">dump.sql</strong>
                    </p>

            <p>
                <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="В public хранятся собранные стили, javascript-код, картинки и тд. Одним словом все, что отвечает за внешний вид. Именно сюда необходимо устанавливать DOCUMENT ROOT вашего веб-сервера. Делать это нужно для того, чтобы вынести 'корень' сайта в папку на уровень выше. Таким образом, пользователи не смогут 'прогуляться' по каталогам приложения.">public</strong>
            </p>

                <p class="ml-3">
                    <i class="fa fa-folder"></i> <strong>css</strong>
                </p>

                    <p class="ml-5">
                        <i class="fa fa-file-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Собранные и минимизированные стили.">app.min.css</strong>
                    </p>

                <p class="ml-3">
                    <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Шрифты, используемые магазином.">font</strong>
                </p>
                <p class="ml-3">
                    <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Шрифты, используемые магазином.">fonts</strong>
                </p>
                <p class="ml-3">
                    <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="В этой директории находятся различные изображения.">img</strong>
                </p>

                    <p class="ml-5">
                        <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Изображения предметов. Именем файла является контрольная сумма, взятая из содержимого файла алгоритмом md5. Такой способ именования файлов необходим для того, чтобы избежать дублирования файлов, если будут загружены несколько одинаковых изображений.">items</strong>
                    </p>
                    <p class="ml-5">
                        <i class="fa fa-folder"></i> <strong>users</strong>
                    </p>

                        <p class="ml-7">
                            <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Изображения плащей пользователей. Именем файла является ник игрока.">cloaks</strong>
                        </p>
                        <p class="ml-7">
                            <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Изображения скинов пользователей. Именем файла является ник игрока.">skins</strong>
                        </p>
                        <p class="ml-7">
                            <i class="fa fa-file-image-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Стандартный скин игрока. Будет активен, если не установлен кастомный.">default.png</strong>
                        </p>

                    <p class="ml-5">
                        <i class="fa fa-file-image-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Картинка предмета без заданного изображения.">empty.png</strong>
                    </p>

                <p class="ml-3">
                    <i class="fa fa-folder"></i> <strong>js</strong>
                </p>

                    <p class="ml-5">
                        <i class="fa fa-file-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Собранный и минимизированный javascript-код.">app.min.js</strong>
                    </p>

                <p class="ml-3">
                    <i class="fa fa-file-image-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Иконка сайта. Отображается в браузере (В заголовках, закладках и тд.)">favicon.ico</strong>
                </p>
                <p class="ml-3">
                    <i class="fa fa-file-text-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Этот файл используется поисковыми роботами для получения информации о том, какие страницы нужно, а какие не нужно индексировать. Правильная настройка содержимого robots.txt положительно влияет на SEO.">robots.txt</strong>
                </p>

            <p>
                <i class="fa fa-folder"></i> <strong>resources</strong>
            </p>

                <p class="ml-3">
                    <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Ассеты - это не собранные файлы стилей и javascript-код. Вы можете внести в них изменения, а затем воспользоваться сборщиком проектов GulpJS, дабы собрать, минимизировать и переместить в нужное место.">assets</strong>
                </p>
                <p class="ml-3">
                    <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Языковые настройки приложения.">lang</strong>
                </p>
                <p class="ml-3">
                    <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="HTML-разметка страниц.">views</strong>
                </p>


            <p>
                <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Директория с маршрутами. Во внутренних файлах задаются url'ы для каждой страницы, а так же соответствующий им контроллер.">routes</strong>
            </p>
            <p>
                <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Логи, кэш и другой рантайм.">storage</strong>
            </p>

                <p class="ml-3">
                    <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="В эту папку будет происходить логирование фреймворком.">logs</strong>
                </p>
                    <p class="ml-5">
                        <i class="fa fa-file-text-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Является основным файлом журнала, если элемент массива log в файле config/app.php имеет значение 'single'.">laravel.log</strong>
                    </p>

            <p>
                <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Здесь 'лежат' юнит-тесты, а также функциональные тесты для тестирования приложения.">tests</strong>
            </p>
            <p>
                <i class="fa fa-folder"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Папка с зависимостями. Именно здесь находится фреймворк Laravel и все его компоненты.">vendor</strong>
            </p>
            <p>
                <i class="fa fa-file-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Файл конфигурации. В нём происходит конфигурирование основных настроек фреймворка.">.env</strong>
            </p>
            <p>
                <i class="fa fa-file-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Шаблонный файл конфигурации. Должен быть переименован в .env.">.env.example</strong>
            </p>
            <p>
                <i class="fa fa-file-o"></i> <strong class="cp" data-toggle="popover" data-placement="right" data-trigger="hover" title="Информация" data-content="Файл сборщика проектов GulpJS.">gulpfile.js</strong>
            </p>
            </p>
            </p>
        </div>
    </div>
@endsection
