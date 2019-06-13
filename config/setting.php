<?php declare(strict_types=1);

return [
    'permission' => [
        'role_names' => [
            'admin' => 'admin',
            'system' => 'system',
        ],
        'permission_names' => [
            'manage_authorization' => 'manage authorization',
            'view_backend' => 'view backend',
        ],
    ],
    'api' => [
        'throttle' => [
            'expires' => 1,
            'limit' => 30,
        ],
        'token' => [
            'access_token_expire' => 60 * 24, // 1day
            'refresh_token_expire' => 60 * 24 * 2, // 2days
        ],
    ],
    'repository' => [
        'limit_pagination' => 100,
        'skip_pagination' => true,
    ],
    'formats' => [
        'date' => 'd/m/Y',
        'datetime_12' => 'd/m/Y h:i:s A',
        'datetime_24' => 'd/m/Y H:i:s',
        'time_12' => 'h:i:s A',
        'time_24' => 'H:i:s',
    ],
];
