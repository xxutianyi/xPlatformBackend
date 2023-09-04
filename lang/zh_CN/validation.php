<?php
/*
 * Copyright (c) XuTianyi 2022.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'accepted' => '应接受:attribute',
    'accepted_if' => '当:other是:value时，应接受:attribute',
    'active_url' => ':attribute应为正确的URL',
    'after' => ':attribute应晚于:date.',
    'after_or_equal' => ':attribute应不早于:date.',
    'alpha' => ':attribute只能包含字母',
    'alpha_dash' => ':attribute只能包含字母、数字、下划线和减号',
    'alpha_num' => ':attribute只能包含字母和数字',
    'array' => ':attribute应为数组',
    'before' => ':attribute应早于:date.',
    'before_or_equal' => ':attribute应不晚于:date.',
    'between' => [
        'array' => ':attribute个数应在:min至:max之间',
        'file' => ':attribute大小应在 :min至:max kB之间',
        'numeric' => ':attribute应为:min至:max.',
        'string' => ':attribute应为:min至:max个字符',
    ],
    'boolean' => ':attribute应为true或false.',
    'confirmed' => ':attribute确认不一致',
    'current_password' => '密码错误',
    'date' => ':attribute应为日期',
    'date_equals' => ':attribute应为:date.',
    'date_format' => ':attribute不符合:format格式',
    'declined' => ':attribute应为declined.',
    'declined_if' => ':attribute应为declined当:other是:value时',
    'different' => ':attribute和:other应不同',
    'digits' => ':attribute应为:digits个数字',
    'digits_between' => ':attribute应为:min至:max个数字',
    'dimensions' => ':attribute比例不正确',
    'distinct' => ':attribute内容重复',
    'doesnt_end_with' => ':attribute不应以:values结尾',
    'doesnt_start_with' => ':attribute不应以:values开头',
    'email' => ':attribute应为正确的电子邮件地址.',
    'ends_with' => ':attribute应以:values结尾',
    'enum' => ':attribute不正确',
    'exists' => ':attribute不存在',
    'file' => ':attribute应为文件',
    'filled' => ':attribute是必填项',
    'gt' => [
        'array' => ':attribute应多于:value个项目',
        'file' => ':attribute应大于:value kB',
        'numeric' => ':attribute应大于:value.',
        'string' => ':attribute应大于:value个字符',
    ],
    'gte' => [
        'array' => ':attribute应不少于:value个项目',
        'file' => ':attribute应不小于:value kB',
        'numeric' => ':attribute应不小于:value.',
        'string' => ':attribute应不小于:value个字符',
    ],
    'image' => ':attribute应为图片',
    'in' => '选择的:attribute不正确',
    'in_array' => ':attribute在:other中不存在',
    'integer' => ':attribute应为整数',
    'ip' => ':attribute应为正确的IP地址.',
    'ipv4' => ':attribute应为正确的IPv4地址.',
    'ipv6' => ':attribute应为正确的IPv6地址.',
    'json' => ':attribute应为正确的JSON string.',
    'lt' => [
        'array' => ':attribute应最少包含:value个项目',
        'file' => ':attribute应小于:value kB',
        'numeric' => ':attribute应小于:value.',
        'string' => ':attribute应小于:value个字符',
    ],
    'lte' => [
        'array' => ':attribute应不多于:value个项目',
        'file' => ':attribute应不大于:value kB',
        'numeric' => ':attribute应不大于:value.',
        'string' => ':attribute应不大于:value个字符',
    ],
    'mac_address' => ':attribute应为正确的MAC地址.',
    'max' => [
        'array' => ':attribute应不多于:max个项目',
        'file' => ':attribute应不大于:max kB',
        'numeric' => ':attribute应不大于:max.',
        'string' => ':attribute应不多于:max个字符',
    ],
    'max_digits' => ':attribute应不多于:max个数字',
    'mimes' => ':attribute应为:values类型的文件',
    'mimetypes' => ':attribute应为:values类型的文件',
    'min' => [
        'array' => ':attribute最少包含:min个项目',
        'file' => ':attribute最小为:min kB',
        'numeric' => ':attribute最小为:min.',
        'string' => ':attribute最少包含:min个字符',
    ],
    'min_digits' => ':attribute最少包含:min个数字',
    'multiple_of' => ':attribute应为多个:value.',
    'not_in' => '选择的:attribute不正确',
    'not_regex' => ':attribute格式不正确',
    'numeric' => ':attribute应为a number.',
    'password' => [
        'letters' => ':attribute最少包含一个字母',
        'mixed' => ':attribute最少包含一个大写字母和一个小写字母',
        'numbers' => ':attribute最少包含一个数字',
        'symbols' => ':attribute最少包含一个特殊字符',
        'uncompromised' => ':attribute在数据泄露中出现过，请重新设置:attribute.',
    ],
    'present' => '应提供:attribute',
    'prohibited' => ':attribute不可用',
    'prohibited_if' => ' 当:other是:value时，:attribute不可用',
    'prohibited_unless' => '当:other不是:value时:attribute不可用',
    'prohibits' => '当提供:attribute时:other不可用',
    'regex' => ':attribute格式错误',
    'required' => ':attribute是必填项',
    'required_array_keys' => ':attribute应为:values的键',
    'required_if' => '当:other是:value时，:attribute是必填项',
    'required_if_accepted' => '当接受:other时，:attribute是必填项',
    'required_unless' => '当:other是:values时，:attribute是必填项',
    'required_with' => '当提供:values时，:attribute是必填项',
    'required_with_all' => '当提供:values时，:attribute是必填项',
    'required_without' => '当不提供:values时，:attribute是必填项',
    'required_without_all' => '当不提供:values时，:attribute是必填项',
    'same' => ':attribute和:other应相同',
    'size' => [
        'array' => ':attribute应包含:size个项目',
        'file' => ':attribute应为:size kB',
        'numeric' => ':attribute应为:size',
        'string' => ':attribute应为:size个字符',
    ],
    'starts_with' => ':attribute应以:values开头',
    'string' => ':attribute应为字符串',
    'timezone' => ':attribute应为时区',
    'unique' => ':attribute已被占用',
    'uploaded' => ':attribute上传失败',
    'url' => ':attribute应为 URL.',
    'uuid' => ':attribute应为 UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name lines. This makes it quick to
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
    */

    'attributes' => [
        'mobile' => '手机号',
        'captcha' => '验证码',
        'email' => '电子邮件',
        'password' => '密码',
    ],

];
