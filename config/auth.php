<?php

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'aluno' => [
        'driver' => 'session',
        'provider' => 'alunos',
    ],
],

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
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];