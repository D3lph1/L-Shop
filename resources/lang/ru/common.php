<?php

return [
    'username' => 'Имя пользователя',
    'email' => 'Адрес электронной почты',
    'password' => 'Пароль',
    'save' => 'Сохранить',
    'cancel' => 'Отмена',
    'close' => 'Закрыть',
    'item' => [
        'type' => [
            'item' => 'Предмет/Блок',
            'permgroup' => 'Привилегия'
        ],
        'units' => [
            'item' => ':amount шт.',
            'permgroup' => ':duration дн.',
            'forever' => 'Навсегда'
        ]
    ],
    'type' => 'Тип',
    'image' => 'Изображение',
    'actions' => 'Действия',
    'edit' => 'Редактировать',
    'table' => [
        'of' => 'из',
        'rows_per_page' => 'Элементов на странице'
    ],
    'skin' => 'Скин',
    'cloak' => 'Плащ',
    'choose_file' => 'Выберите файл',
    'unclear_docs' => 'Что-то непонятно? Прочтите <a href=":link" target="_blank">документацию</a>.',
    'server' => 'Сервер',
    'category' => 'Категория',
    'banned' => [
        'one' => [
            'temporarily' => [
                'with_reason' => 'Аккаунт этого пользователя заблокирован по причине ":reason". Блокировка истекает: :until',
                'without_reason' => 'Аккаунт этого пользователя заблокирован. Блокировка истекает: :until.'
            ],
            'permanently' => [
                'with_reason' => 'Аккаунт этого пользователя заблокирован навсегда по причине ":reason".',
                'without_reason' => 'Аккаунт этого пользователя заблокирован навсегда.'
            ],
        ],
        'many' => [
            'title' => 'Аккаунт этого пользователя заблокирован. Неистекшие блокировки:',
            'temporarily' => [
                'with_reason' => 'Истекает :until. Причина: ":reason".',
                'without_reason' => 'Истекает :until.'
            ],
            'permanently' => [
                'with_reason' => 'Заблокирован навсегда по причине ":reason".',
                'without_reason' => 'Заблокирован навсегда.'
            ],
        ]
    ],
    'forever' => 'Навсегда',
    'yes' => 'Да',
    'no' => 'Нет'
];
