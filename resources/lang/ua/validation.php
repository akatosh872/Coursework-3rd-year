<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Мовні рядки валідації
    |--------------------------------------------------------------------------
    |
    | Нижче наведені мовні рядки, які містять типові повідомлення про помилки,
    | використовувані класом валідатора. Деякі правила мають кілька варіантів,
    | наприклад, правила для розміру. Ви можете вільно змінювати кожне з цих повідомлень тут.
    |
    */

    'accepted' => 'Поле :attribute повинно бути прийнято.',
    'accepted_if' => 'Поле :attribute повинно бути прийнято, коли :other - :value.',
    'active_url' => 'Поле :attribute не є дійсним URL.',
    'after' => 'Поле :attribute повинно бути датою після :date.',
    'after_or_equal' => 'Поле :attribute повинно бути датою після або рівною :date.',
    'alpha' => 'Поле :attribute повинно містити лише літери.',
    'alpha_dash' => 'Поле :attribute повинно містити лише літери, цифри, дефіси та підкреслення.',
    'alpha_num' => 'Поле :attribute повинно містити лише літери та цифри.',
    'array' => 'Поле :attribute повинно бути масивом.',
    'before' => 'Поле :attribute повинно бути датою до :date.',
    'before_or_equal' => 'Поле :attribute повинно бути датою до або рівною :date.',
    'between' => [
        'numeric' => 'Поле :attribute повинно бути між :min та :max.',
        'file' => 'Поле :attribute повинно бути між :min та :max кілобайт.',
        'string' => 'Поле :attribute повинно бути між :min та :max символів.',
        'array' => 'Поле :attribute повинно містити від :min до :max елементів.',
    ],
    'boolean' => 'Поле :attribute повинно бути true або false.',
    'confirmed' => 'Підтвердження поля :attribute не співпадає.',
    'current_password' => 'Неправильний пароль.',
    'date' => 'Поле :attribute не є дійсною датою.',
    'date_equals' => 'Поле :attribute повинно бути датою рівною :date.',
    'date_format' => 'Поле :attribute не відповідає формату :format.',
    'declined' => 'Поле :attribute повинно бути відхилено.',
    'declined_if' => 'Поле :attribute повинно бути відхилено, коли :other - :value.',
    'different' => 'Поля :attribute та :other повинні бути різними.',
    'digits' => 'Поле :attribute повинно містити :digits цифр.',
    'digits_between' => 'Поле :attribute повинно бути між :min та :max цифр.',
    'dimensions' => 'Поле :attribute має недійсні розміри зображення.',
    'distinct' => 'Поле :attribute має значення, яке дублюється.',
    'email' => 'Поле :attribute повинно бути дійсною адресою електронної пошти.',
    'ends_with' => 'Поле :attribute повинно закінчуватися одним із наступних: :values.',
    'enum' => 'Вибране значення для :attribute недійсне.',
    'exists' => 'Вибране значення для :attribute недійсне.',
    'file' => 'Поле :attribute повинно бути файлом.',
    'filled' => 'Поле :attribute повинно мати значення.',
    'gt' => [
        'numeric' => 'Поле :attribute повинно бути більшим за :value.',
        'file' => 'Поле :attribute повинно бути більшим за :value кілобайт.',
        'string' => 'Поле :attribute повинно містити більше :value символів.',
        'array' => 'Поле :attribute повинно містити більше :value елементів.',
    ],
    'gte' => [
        'numeric' => 'Поле :attribute повинно бути більшим або рівним :value.',
        'file' => 'Поле :attribute повинно бути більшим або рівним :value кілобайт.',
        'string' => 'Поле :attribute повинно бути більшим або рівним :value символів.',
        'array' => 'Поле :attribute повинно містити :value елементів або більше.',
    ],
    'image' => 'Поле :attribute повинно бути зображенням.',
    'in' => 'Вибране значення для :attribute недійсне.',
    'in_array' => 'Поле :attribute не існує в :other.',
    'integer' => 'Поле :attribute повинно бути цілим числом.',
    'ip' => 'Поле :attribute повинно бути дійсною IP-адресою.',
    'ipv4' => 'Поле :attribute повинно бути дійсною IPv4-адресою.',
    'ipv6' => 'Поле :attribute повинно бути дійсною IPv6-адресою.',
    'json' => 'Поле :attribute повинно бути дійсним рядком JSON.',
    'lt' => [
        'numeric' => 'Поле :attribute повинно бути меншим за :value.',
        'file' => 'Поле :attribute повинно бути меншим за :value кілобайт.',
        'string' => 'Поле :attribute повинно містити менше :value символів.',
        'array' => 'Поле :attribute повинно містити менше :value елементів.',
    ],
    'lte' => [
        'numeric' => 'Поле :attribute повинно бути меншим або рівним :value.',
        'file' => 'Поле :attribute повинно бути меншим або рівним :value кілобайт.',
        'string' => 'Поле :attribute повинно бути меншим або рівним :value символів.',
        'array' => 'Поле :attribute повинно містити не більше :value елементів.',
    ],
    'mac_address' => 'Поле :attribute повинно бути дійсною MAC-адресою.',
    'max' => [
        'numeric' => 'Поле :attribute не повинно перевищувати :max.',
        'file' => 'Поле :attribute не повинно перевищувати :max кілобайт.',
        'string' => 'Поле :attribute не повинно перевищувати :max символів.',
        'array' => 'Поле :attribute не повинно містити більше :max елементів.',
    ],
    'mimes' => 'Поле :attribute повинно бути файлом типу: :values.',
    'mimetypes' => 'Поле :attribute повинно бути файлом типу: :values.',
    'min' => [
        'numeric' => 'Поле :attribute повинно бути не менше :min.',
        'file' => 'Поле :attribute повинно бути не менше :min кілобайт.',
        'string' => 'Поле :attribute повинно бути не менше :min символів.',
        'array' => 'Поле :attribute повинно містити принаймні :min елементів.',
    ],
    'multiple_of' => 'Поле :attribute повинно бути кратним :value.',
    'not_in' => 'Вибране значення для :attribute недійсне.',
    'not_regex' => 'Формат поля :attribute недійсний.',
    'numeric' => 'Поле :attribute повинно бути числом.',
    'password' => 'Неправильний пароль.',
    'present' => 'Поле :attribute повинно бути присутнім.',
    'prohibited' => 'Поле :attribute заборонено.',
    'prohibited_if' => 'Поле :attribute заборонено, коли :other - :value.',
    'prohibited_unless' => 'Поле :attribute заборонено, якщо :other не знаходиться в :values.',
    'prohibits' => 'Поле :attribute забороняє :other бути присутнім.',
    'regex' => 'Формат поля :attribute недійсний.',
    'required' => 'Поле :attribute є обов\'язковим.',
    'required_array_keys' => 'Поле :attribute повинно містити записи для: :values.',
    'required_if' => 'Поле :attribute є обов\'язковим, коли :other - :value.',
    'required_unless' => 'Поле :attribute є обов\'язковим, якщо :other не знаходиться в :values.',
    'required_with' => 'Поле :attribute є обов\'язковим, коли присутні :values.',
    'required_with_all' => 'Поле :attribute є обов\'язковим, коли присутні всі :values.',
    'required_without' => 'Поле :attribute є обов\'язковим, коли відсутні :values.',
    'required_without_all' => 'Поле :attribute є обов\'язковим, коли відсутні всі :values.',
    'same' => 'Поля :attribute та :other повинні співпадати.',
    'size' => [
        'numeric' => 'Поле :attribute повинно бути розміром :size.',
        'file' => 'Поле :attribute повинно бути розміром :size кілобайт.',
        'string' => 'Поле :attribute повинно містити :size символів.',
        'array' => 'Поле :attribute повинно містити :size елементів.',
    ],
    'starts_with' => 'Поле :attribute повинно починатися одним з наступних: :values.',
    'string' => 'Поле :attribute повинно бути рядком.',
    'timezone' => 'Поле :attribute повинно бути дійсним часовим поясом.',
    'unique' => 'Такий :attribute вже існує.',
    'uploaded' => 'Не вдалося завантажити файл :attribute.',
    'url' => 'Поле :attribute повинно бути дійсною URL-адресою.',
    'uuid' => 'Поле :attribute повинно бути дійсним UUID.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
