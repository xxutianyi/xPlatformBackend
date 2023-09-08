<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'wework' => [
        'corp_id' => env('WEWORK_CORP_ID'),
        'app' => [
            'id' => env('WEWORK_AGENT_ID'),
            'secret' => env('WEWORK_APP_SECRET'),
        ],
        'finance' => [
            'agent' => env('WEWORK_FINANCE_AGENT'),
            'secret' => env('WEWORK_FINANCE_SECRET'),
            'key' => env('WEWORK_FINANCE_PRIVATE_KEY'),
        ]
    ],

    'tencent-cloud' => [

        'secret_id' => env('TENCENT_CLOUD_ID'),
        'secret_key' => env('TENCENT_CLOUD_KEY'),

        'sms' => [
            'signature' => env('SMS_SIGNATURE'),

            'app_id' => env('SMS_SDK_APP_ID'),

            'templates' => [

                'verify' => env('SMS_TEMPLATE_VERIFY'),
                'password' => env('SMS_TEMPLATE_PASSWORD'),

            ]
        ]
    ],
];
