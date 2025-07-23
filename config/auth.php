<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Authentication Settings
    |--------------------------------------------------------------------------
    |
    | You may change these default settings as needed. The default guard
    | is typically "web", and the default password broker is usually "users".
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Here you may define every authentication guard for your application.
    | Laravel uses "session" driver for web, but you can add others like "token".
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'aluno' => [
            'driver' => 'session',
            'provider' => 'alunos',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | This defines how users are retrieved from your storage. You may use
    | Eloquent or database query builder. You can create multiple providers.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'alunos' => [
            'driver' => 'eloquent',
            'model' => App\Models\Aluno::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    |
    | You can specify multiple password brokers if you have more than one
    | user table or model. The default expiration is 60 minutes.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'alunos' => [
            'provider' => 'alunos',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | This defines how many seconds before a password confirmation times out
    | and the user is asked to re-enter their password. Default is 3 hours.
    |
    */

    'password_timeout' => 10800,

];
