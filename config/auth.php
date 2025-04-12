<?php

return [

    'defaults' => [
        'guard' => 'temples',  // default guard
        'passwords' => 'temple_users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'superadmins' => [
            'driver' => 'session',
            'provider' => 'superadmins',
        ],

        'temples' => [
            'driver' => 'session',
            'provider' => 'temples',
        ],

        'api' => [
            'driver' => 'sanctum',
            'provider' => 'temples',
            'hash' => false,
        ],

        'niti_admin' => [
            'driver' => 'sanctum',  // Sanctum for API auth
            'provider' => 'niti_admins',
            'hash' => false,
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'superadmins' => [
            'driver' => 'eloquent',
            'model' => App\Models\SuperAdmin::class,
        ],

        'temples' => [
            'driver' => 'eloquent',
            'model' => App\Models\TempleUser::class,
        ],

        'niti_admins' => [ // FIXED: must match 'provider' name in guard
            'driver' => 'eloquent',
            'model' => App\Models\NitiadminLogin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'temple_users' => [
            'provider' => 'temples',
            'table' => 'password_resets',
            'expire' => 60,
        ],

        'niti_admins' => [ // optionally support password resets
            'provider' => 'niti_admins',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
