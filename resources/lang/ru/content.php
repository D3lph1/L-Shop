<?php

return [
    'frontend' => [
        'auth' => [
            'login' => [
                'title' => 'Вход',
                'login' => 'Войти',
                'purchase_without_auth' => 'Покупка без авторизации',
                'forgot_password' => 'Забыли пароль?',
                'logout' => 'Выйти'
            ],
            'register' => [
                'title' => 'Регистрация'
            ],
            'activation' => [
                'sent' => [
                    'title' => 'Ожидание активации',
                    'description' => 'На почтовый ящик, указанный вами, отправлено письмо для подтверждения регистрации.
                              <p><p>Если письмо не пришло, вы можете отправить его заново.</p></p>',
                    'repeat' => 'Отправить повторно'
                ]
            ],
            'password' => [
                'forgot' => [
                    'title' => 'Восстановление пароля',
                    'continue' => 'Продолжить'
                ],
                'reset' => [
                    'title' => 'Сбросить пароль'
                ]
            ],
            'servers' => [
                'title' => 'Выбор сервера'
            ]
        ]
    ],
    'admin' => [
        //
    ],
    'layout' => [
        'shop' => [
            'sidebar' => [
                'basic' => [
                    'catalog' => 'Каталог',
                    'cart' => 'Корзина'
                ],
                'profile' => [
                    'title' => 'Профиль',
                    'character' => 'Персонаж',
                    'settings' => 'Настройки',
                    'information' => [
                        'title' => 'Информация',
                        'sub_items' => [
                            'payments' => 'История платежей',
                            'cart' => 'Внутриигровая корзина'
                        ]
                    ]
                ],
                'admin' => [
                    'title' => 'Администрирование',
                    'control' => [
                        'title' => 'Управление',
                        'sub_items' => [
                            'main_settings' => 'Основные настройки',
                            'payments' => 'Платежи',
                            'api' => 'API',
                            'security' => 'Безопасность',
                            'optimization' => 'Оптимизация'
                        ]
                    ],
                    'servers' => [
                        'title' => 'Серверы',
                        'sub_items' => [
                            'add' => 'Добавить',
                            'edit' => 'Редактировать'
                        ]
                    ],
                    'products' => [
                        'title' => 'Товары',
                        'sub_items' => [
                            'add' => 'Добавить',
                            'edit' => 'Редактировать'
                        ]
                    ],
                    'items' => [
                        'title' => 'Предметы',
                        'sub_items' => [
                            'add' => 'Добавить',
                            'edit' => 'Редактировать'
                        ]
                    ],
                    'news' => [
                        'title' => 'Новости',
                        'sub_items' => [
                            'add' => 'Добавить',
                            'edit' => 'Редактировать'
                        ]
                    ],
                    'pages' => [
                        'title' => 'Статические страницы',
                        'sub_items' => [
                            'add' => 'Добавить',
                            'edit' => 'Редактировать'
                        ]
                    ],
                    'users' => [
                        'title' => 'Пользователи',
                        'sub_items' => [
                            'edit' => 'Редактировать'
                        ]
                    ],
                    'other' => [
                        'title' => 'Другое',
                        'sub_items' => [
                            'rcon' => 'RCON консоль',
                            'debug' => 'Отладка',
                        ]
                    ],
                    'statistic' => [
                        'title' => 'Статистика',
                        'sub_items' => [
                            'show' => 'Просмотр статистики',
                            'payments' => 'История платежей',
                        ]
                    ],
                    'info' => [
                        'title' => 'Информация',
                        'sub_items' => [
                            'docs' => 'Документация',
                            'about' => 'О системе L-Shop',
                        ]
                    ]
                ]
            ]
        ],
        'news' => [
            'empty' => 'Новости отсутствуют',
            'read' => 'Читать полностью',
            'load' => 'Загрузить ещё'
        ]
    ]
];
