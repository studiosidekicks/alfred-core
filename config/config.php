<?php

return [
    'auth' => [
        'front' => [
            'is_enabled' => env('IS_FRONT_AUTH_ENABLED', true),
            'model' => Studiosidekicks\Alfred\Auth\Front\Entities\FrontUser::class,
        ],
        'back' => [
            'is_enabled' => env('IS_BACK_AUTH_ENABLED', true),
            'model' => Studiosidekicks\Alfred\Auth\Back\Entities\BackUser::class,
            'role_model' => Studiosidekicks\Alfred\Auth\Back\Entities\Role::class,
            'primary_account' => [
                'email' => env('PRIMARY_ACCOUNT_EMAIL'),
            ]
        ]
    ],
    'api' => [
        'version' => 1,
    ],
    'spa_url' => env('ALFRED_SPA_URL', env('APP_URL')),
];
