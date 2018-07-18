<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_strict'         => 'Поле ":attribute" должно содержать только латинские буквы.',
    'alpha_dash'           => 'Поле ":attribute" должно содержать только латинские буквы, цифры, знаки тире и подчеркивания.',
    'alpha_dash_strict'    => 'Поле ":attribute" должно содержать только латинские буквы, цифры, знаки тире и подчеркивания.',
    'alpha_num'            => 'Поле ":attribute" может содержать только буквы и цифры.',
    'alpha_num_strict'     => 'Поле ":attribute" может содержать только латинские буквы и цифры.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'Поле :attribute должно иметь булевое значение.',
    'confirmed'            => 'Вы должны подтведить значение поля ":attribute".',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Поле ":attribute" должно быть корректным адресом электронной почты.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'Поле ":attribute" должно быть файлом.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'Поле ":attribute" должно быть изображением.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'Значение поля ":attribute" должно быть целым числом.',
    'ip'                   => 'Значение поля ":attribute" должно быть валидным IP адресом.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'Значение поле ":attribute" не может быть больше :max.',
        'file'    => 'Файл, загруженный в поле ":attribute" не может быть больше :max килобайт.',
        'string'  => 'Значение поля ":attribute" не может быть длиннее :max символов.',
        'array'   => 'Поле ":attribute" не может содержать больше :max элементов.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'Поле ":attribute" должно соответствовать MIME-типам: :values.',
    'min'                  => [
        'numeric' => 'Значение поле ":attribute" не может быть меньше :min.',
        'file'    => 'Файл, загруженный в поле ":attribute" не может быть меньше :min килобайт.',
        'string'  => 'Значение поля ":attribute" не может быть короче :min символов.',
        'array'   => 'Поле ":attribute" не может содержать меньше :min элементов.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'Поле ":attribute" должно содержать числовое значение.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Поле ":attribute" содержит недопустимые символы.',
    'required'             => 'Поле ":attribute" обязательно для заполнения',
    'required_if'          => 'Поле ":attribute" обязательно для заполнения, так как ":other" находится в значении ":value".',
    'required_unless'      => 'Поле ":attribute" обязательно для заполнения, так как ":other" не находится в значении ":values".',
    'required_with'        => 'Поле ":attribute" обязательно для заполнения так как ":values" представлено.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'Поле ":attribute" должно быть равно :size.',
        'file'    => 'Файл, загруженный в поле ":attribute" должен иметь размер в :size килобайт.',
        'string'  => 'Поле ":attribute" должно иметь размер в :size символов.',
        'array'   => 'Поле ":attribute" должно содержать :size элементов.',
    ],
    'string'               => 'Поле ":attribute" должно быть строкой.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => '":attribute" уже используется.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Поле ":attribute" должно быть корректным URL.',

    // Specify validation messages
    'api_sashok_auth_format_regex' => 'Поле "Формат" должно содержать маркер {username}.',
    'valid_regex' => 'Поле ":attribute" должно быть валидным регулярным выражением.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'username' => 'Имя пользователя',
        'email' => 'Адрес электронной почты',
        'password' => 'Пароль',
        'password_confirmation' => 'Подтвердите пароль',
        'balance' => 'Баланс',
        'skin' => 'Скин',
        'cloak' => 'Плащ',
        'block_duration' => 'Длительность блокировки',

        'min_sum' => 'Минимальная сумма пополнения баланса',
        'currency' => 'Текстовое представление валюты',
        'currency_html' => 'Форматированное представление валюты',

        'robokassa_login' => 'Robkassa. Логин',
        'robokassa_password1' => 'Robkassa. Пароль №1',
        'robokassa_password2' => 'Robkassa. Пароль №2',
        'robokassa_algo' => 'Robkassa. Алгоритм расчета контрольной суммы',
        'robokassa_test' => 'Robokassa. Тестовый режим',

        'interkassa_checkout_id' => 'Interkassa. Логин',
        'interkassa_key' => 'Interkassa. Пароль №1',
        'interkassa_test_key' => 'Interkassa. Пароль №2',
        'interkassa_currency' => 'Interkassa. Валюта',
        'interkassa_algo' => 'Interkassa. Алгоритм расчета контрольной суммы',
        'interkassa_test' => 'Interkassa. Тестовый режим',

        'page_title' => 'Заголовок страницы',
        'page_content' => 'Содержимое страницы',
        'page_url' => 'Адрес страницы',

        'news_title' => 'Заголовок новости',
        'news_content' => 'Содержимое новости',

        'server_name' => 'Имя сервера',

        'products_per_page' => 'Количество товара на 1 странице магазина',
        'payments_per_page' => 'Количество элементов на 1 странице истории платежей в профиле пользователя',
        'cart_per_page' => 'Количество элементов на 1 странице внутриигровой корзины в профиле пользователя',
        'news_first_portion' => 'Количество новостей, находящихся на экране при загрузке',
        'news_per_page' => 'Количество подгружаемых за раз новостей',
        'cart_capacity' => 'Максимальная вместимость корзины',
        'ttl_statistic' => 'Время существования кэша статистики',
        'ttl_statistic_pages' => 'Время существования кэша статических страниц',
        'ttl_news' => 'Время существования кэша новостей',
        'ttl_monitoring' => 'Время существования кэша мониторинга серверов',
        'sashok_launcher_auth_error_message' => 'Сообщение при неверном вводе данных пользователем',
        'sashok_launcher_auth_format' => 'Формат',
        'separator' => 'Разделитель',
        'recaptcha_public_key' => 'Публичный ключ reCAPTCHA',
        'recaptcha_secret_key' => 'Секретный ключ reCAPTCHA',
        'test_mail_address' => 'Адрес электронной почты, на который будет отправлено письмо',
        'sort_priority' => 'Приоритет сортировки',
        'server_ip' => 'IP адрес сервера',
        'server_port' => 'Порт сервера',
        'server_password' => 'RCON пароль',
        'rcon_connection_timeout' => 'Таймаут соединения',
        'rcon_monitoring_pattern' => 'Формат ответа',
        'enable_monitoring' => 'Включить мониторинг серверов',
        'signup_redirect' => 'Перенаправлять пользователя на кастомный URL после регистрации',
        'signup_redirect_url' => 'Кастомный URL',

        'character_skin_enabled' => 'Разрешить пользователям устанавливать скины',
        'character_cloak_enabled' => 'Разрешить пользователям устанавливать плащи',
        'character_hd_skin_enabled' => 'Разрешить пользователям устанавливать HD скины',
        'character_hd_cloak_enabled' => 'Разрешить пользователям устанавливать HD плащи',
        'character_skin_max_file_size' => 'Максимальный размер файла скина',
        'character_cloak_max_file_size' => 'Максимальный размер файла плаща',

        'categories.*.*' => 'Имя категории'
    ],
];
