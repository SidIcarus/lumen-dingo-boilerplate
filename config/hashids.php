<?php declare(strict_types=1);

return [



    'default' => 'main',



    'connections' => [

        'main' => [
            'salt' => env('HASH_ID_KEY', env('APP_KEY')),
            'length' => env('HASH_ID_LENGTH', 32),
        ],

        'alternative' => [
            'salt' => 'your-salt-string',
            'length' => 'your-length-integer',
        ],

    ],

];
