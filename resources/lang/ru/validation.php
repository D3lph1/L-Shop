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
    'alpha_dash'           => 'Поле ":attribute" должно содержать только буквы, цифры, знаки тире и подчеркивания',
    'alpha_num'            => 'Поле ":attribute" может содержать только буквы и цифры',
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
    'confirmed'            => 'Вы должны подтведить значение поля ":attribute"',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Поле ":attribute" должно быть корректным адресом электронной почты',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'Поле ":attribute" должно быть файлом',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'Поле ":attribute" должно быть изображением',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'Значение поля ":attribute" должно быть целым числом',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'Значение поле ":attribute" не может быть больше :min.',
        'file'    => 'Файл, загруженный в поле ":attribute" не может быть больше :min килобайт.',
        'string'  => 'Значение поля ":attribute" не может быть длиннее :min символов.',
        'array'   => 'Поле ":attribute" не может содержать больше :min элементов.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'Значение поле ":attribute" не может быть меньше :min.',
        'file'    => 'Файл, загруженный в поле ":attribute" не может быть меньше :min килобайт.',
        'string'  => 'Значение поля ":attribute" не может быть короче :min символов.',
        'array'   => 'Поле ":attribute" не может содержать меньше :min элементов.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'Поле ":attribute" должно содержать числовое значение',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'Поле ":attribute" обязательно для заполнения',
    'required_if'          => 'Поле ":attribute" обязательно для заполнения, так как ":other" находиться в значении ":value"',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'Поле ":attribute" должно быть равно :size.',
        'file'    => 'Файл, загруженный в поле ":attribute" должен иметь размер в :size килобайт',
        'string'  => 'Поле ":attribute" должно иметь размер в :size символов',
        'array'   => 'Поле ":attribute" должно содержать :size элементов',
    ],
    'string'               => 'Поле ":attribute" должно быть строкой',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => '":attribute" уже используется',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

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

    'attributes' => [],

];
