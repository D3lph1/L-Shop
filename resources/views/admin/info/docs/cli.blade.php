{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Документация по CLI L - Shop
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-terminal fa-left-big"></i>Документация по CLI L - Shop</h1>
        </div>
        <div class="card card-block">
            <h3 class="card-title">Введение</h3>
            <p class="card-text">
                CLI (<b>c</b>ommand <b>l</b>ine <b>i</b>nterface) предоставляет удобный интерфейс для управления магазином
                из командной строки.
            </p>
            <h3 class="card-title">Основы</h3>
            <p class="card-text">
                Для ввода команды вам необходимо перейти в корень директории с L-Shop, туда где лежит файл <code>artisan</code>
                (Как в windows, так и в oc семейства linux сделать это можно командой <code>cd &lt;директория&gt;</code>).
                Далее, в консоль (терминал) следует ввести <code>php artisan </code>.<br>
                После этого вы можете вводить не только команды, описанные ниже, но и те, которые идут "из коробки" с
                фреймворком Laravel. Посмотреть их можно выполнив команду <code>php artisan list</code>.
                <p>
                    Далее вы встретите такие термины, как аргумент команды и опции. Аргументы прописываются в команду через пробелы.
                    В сигнатуре комманды аргументы написаны в фигурных скобках.<br>
                    Опции же прописываются в команду после прификса из двух знаков тире. Опции в отличии от аргументов обычно имеют вид
                    <strong>опция=значение</strong> (например, <code>--key=value</code>), однако, также встечаются и опции "переключатели",
                    которые не имеют значения (например, <code>--checked</code>).<br>
                    Аргументы, обычно, обязательны для ввода, а вот опции - опциональны (Да, да, знаю, масло масляное).<br>
                    Так, в строке <code>php artisan example two cars --dangerous --test=on</code> аргументами будут являться
                    <code>two</code> <code>cars</code>, а опциями - <code>--dangerous</code>, <code>--test=on</code>,
                    при чем, первая из них является опцией "переключателем" и не имеет значения.
                </p>
            </p>
            <h3 class="card-title">Управление пользователями</h3>
            <h4 class="card-title">Создать пользователя</h4>
            <p class="card-text">
                <p>Сигнатура: <code>php artisan user:create {username} {email} {password} --balance=0 --activate --admin</code></p>
                <p>Примеры:</p>
                <p>
                    <code>php artisan user:create D3lph1 d3lph1.contact@gmail.com 123456</code> - Создаст обычного пользователя
                    с логином <strong>D3lph1</strong>, с адресом электронной почты <strong>d3lph1.contact@gmail.com</strong>
                    и паролем <strong>123456</strong>
                </p>
                <p>
                    <code>php artisan user:create WhilD0S whiled0s@gmail.com 123456 --balance=87 --activate --admin</code> - Создаст обычного пользователя
                    с логином <strong>WhilD0S</strong> с адресом электронной почты <strong>whiled0s@gmail.com</strong>,
                    паролем <strong>123456</strong>, балансом <strong>87</strong>, мгновенно активирует его аккаунт, а также,
                    сделает его администратором.
                </p>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Элемент</th>
                        <th>Описание</th>
                        <th>Тип</th>
                        <th>Обзателен</th>
                        <th>Значение по умолчанию</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>username</td>
                        <td>Имя пользователя (логин)</td>
                        <td>Аргумент</td>
                        <td>Да</td>
                        <td>Нет</td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td>Адрес электронной почты ползователя</td>
                        <td>Аргумент</td>
                        <td>Да</td>
                        <td>Нет</td>
                    </tr>
                    <tr>
                        <td>password</td>
                        <td>Пароль пользователя</td>
                        <td>Аргумент</td>
                        <td>Да</td>
                        <td>Нет</td>
                    </tr>
                    <tr>
                        <td>balance</td>
                        <td>Баланс пользователя. Целое или дробное положительное число</td>
                        <td>Опция</td>
                        <td>Нет</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>activate</td>
                        <td>Нужно ли активировать пользователя сразу. Переключатель</td>
                        <td>Опция</td>
                        <td>Нет</td>
                        <td>false</td>
                    </tr>
                    <tr>
                        <td>admin</td>
                        <td>Выдать ли пользователю привелегии администратора. Переключатель</td>
                        <td>Опция</td>
                        <td>Нет</td>
                        <td>false</td>
                    </tr>
                    </tbody>
                </table>
            </p>
            <h4 class="card-title">Активировать пользователя</h4>
            <p class="card-text">
                <p>Сигнатура: <code>php artisan user:activate {username}</code></p>
                <p>Примеры:</p>
                <p>
                    <code>php artisan user:activate WhilD0S</code> - активирует аккаунт пользователя <code>WhilD0S</code>.
                </p>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Элемент</th>
                        <th>Описание</th>
                        <th>Тип</th>
                        <th>Обзателен</th>
                        <th>Значение по умолчанию</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>username</td>
                        <td>Имя пользователя (логин)</td>
                        <td>Аргумент</td>
                        <td>Да</td>
                        <td>Нет</td>
                    </tr>
                    </tbody>
                </table>
            </p>
            <h4 class="card-title">Удалить пользователя</h4>
            <p class="card-text">
                <p>Сигнатура: <code>php artisan user:remove {username}</code></p>
                <p>Примеры:</p>
                <p>
                    <code>php artisan user:remove D3lph1</code> - Удалит пользователя <code>D3lph1</code>.
                </p>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Элемент</th>
                        <th>Описание</th>
                        <th>Тип</th>
                        <th>Обзателен</th>
                        <th>Значение по умолчанию</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>username</td>
                        <td>Имя пользователя (логин)</td>
                        <td>Аргумент</td>
                        <td>Да</td>
                        <td>Нет</td>
                    </tr>
                    </tbody>
                </table>
            </p>
            <h4 class="card-title">Заблокировать пользователя</h4>
            <p class="card-text">
            <p>Сигнатура: <code>php artisan user:block {username} {duration} --reason=""</code></p>
            <p>Примеры:</p>
            <p>
                <code>php artisan user:block D3lph1 30 --reason="Нарушение правил ресурса"</code> - Заблокирует
                пользователя <code>D3lph1</code> на 40 дней с причиной "Нарушение правил ресурса".
            </p>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>Элемент</th>
                    <th>Описание</th>
                    <th>Тип</th>
                    <th>Обзателен</th>
                    <th>Значение по умолчанию</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>username</td>
                    <td>Имя пользователя (логин)</td>
                    <td>Аргумент</td>
                    <td>Да</td>
                    <td>Нет</td>
                </tr>
                <tr>
                    <td>duration</td>
                    <td>Длительность блокировки (в днях). Если отстутсвует или равен "0", пользователь блокируется навсегда.</td>
                    <td>Аргумент</td>
                    <td>Нет</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>reason</td>
                    <td>Причина блокировки.</td>
                    <td>Опция</td>
                    <td>Нет</td>
                    <td>Нет</td>
                </tr>
                </tbody>
            </table>
            </p>
            <h4 class="card-title">Разблокировать пользователя</h4>
            <p class="card-text">
            <p>Сигнатура: <code>php artisan user:unblock {username}</code></p>
            <p>Примеры:</p>
            <p>
                <code>php artisan user:unblock D3lph1</code> - Разблокирует пользоваетля <code>D3lph1</code>.
            </p>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>Элемент</th>
                    <th>Описание</th>
                    <th>Тип</th>
                    <th>Обзателен</th>
                    <th>Значение по умолчанию</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>username</td>
                    <td>Имя пользователя (логин)</td>
                    <td>Аргумент</td>
                    <td>Да</td>
                    <td>Нет</td>
                </tr>
                </tbody>
            </table>
            </p>
            <h3 class="card-title">Управление платежами</h3>
            <h4 class="card-title">Завершить платеж</h4>
            <p class="card-text">
                <p>Сигнатура: <code>php artisan payment:complete {id}</code></p>
                <p>Примеры:</p>
                <p>
                    <code>php artisan payment:complete 17</code> - Завершит платёж с идентификатором <code>17</code>
                    и выдаст пользователю все, что храниться в платеже. Это могут быть товары, а могут -
                    деньги на баланс магазина.
                </p>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Элемент</th>
                        <th>Описание</th>
                        <th>Тип</th>
                        <th>Обзателен</th>
                        <th>Значение по умолчанию</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>username</td>
                        <td>Идентификатор платежа</td>
                        <td>Аргумент</td>
                        <td>Да</td>
                        <td>Нет</td>
                    </tr>
                    </tbody>
                </table>
            </p>
            <h3 class="card-title">Сервер</h3>
            <h4 class="card-title">RCON управление</h4>
            <p class="card-text">
            <p>Сигнатура: <code>php artisan rcon</code></p>
            <p>Эта команда не имеет ни аргументов, ни опций. Она является "интерактивной". После ее ввода следуйте инструкциям.</p>
            </p>
        </div>
    </div>
@endsection
