<?php declare(strict_types=1);

return [



    'standardsTree' => env('API_STANDARDS_TREE', 'x'),



    'subtype' => env('API_SUBTYPE', 'lumen.dingo.boilerplate'),



    'version' => env('API_VERSION', 'v1'),



    'prefix' => env('API_PREFIX', null),



    'domain' => env('API_DOMAIN', env('APP_URL', 'http://lumen-dingo-boilerplate.test')),



    'name' => env('API_NAME', env('APP_NAME', 'Lumen Dingo Boilerplate')),



    'conditionalRequest' => env('API_CONDITIONAL_REQUEST', true),



    'strict' => env('API_STRICT', true),



    'debug' => env('API_DEBUG', env('APP_DEBUG', false)),



    'errorFormat' => [
        'message' => ':message',
        'errors' => ':errors',
        'code' => ':code',
        'status_code' => ':status_code',
        'debug' => ':debug',
    ],



    'middleware' => [

    ],



    'auth' => [

    ],



    'throttling' => [

    ],



    'transformer' => env('API_TRANSFORMER', Dingo\Api\Transformer\Adapter\Fractal::class),



    'defaultFormat' => env('API_DEFAULT_FORMAT', 'json'),

    'formats' => [

        'json' => Dingo\Api\Http\Response\Format\Json::class,

    ],

    'formatsOptions' => [

        'json' => [
            'pretty_print' => env('API_JSON_FORMAT_PRETTY_PRINT_ENABLED', false),
            'indent_style' => env('API_JSON_FORMAT_INDENT_STYLE', 'space'),
            'indent_size' => env('API_JSON_FORMAT_INDENT_SIZE', 2),
        ],

    ],

];
