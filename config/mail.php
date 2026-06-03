<?php

return [

    'default' => env('MAIL_MAILER', 'log'),

    'mailers' => [

        'smtp' => [
            'transport'  => 'smtp',
            'host'       => env('MAIL_HOST', 'smtp.gmail.com'),
            'port'       => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username'   => env('MAIL_USERNAME'),
            'password'   => env('MAIL_PASSWORD'),
            'timeout'    => 10,
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'log' => [
            'transport' => 'log',
            'channel'   => env('LOG_CHANNEL', 'stack'),
        ],

    ],

    // Who receives contact form notifications
    'contact_recipient' => env('CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'kushal.upr@gmail.com')),

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@kushalghimire57.com.np'),
        'name'    => env('MAIL_FROM_NAME', 'Kushal Portfolio'),
    ],

];
