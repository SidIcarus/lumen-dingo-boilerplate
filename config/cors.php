<?php declare(strict_types=1);

return [
    /**
     * A cors profile determines which origins, methods, headers are allowed for
     *  a given requests. The `DefaultProfile` reads its configuration from this
     *  config file.
     *
     * You can easily create your own cors profile.
     *
     * @see https://github.com/spatie/laravel-cors/#creating-your-own-cors-profile
     */
    'cors_profile' => Spatie\Cors\CorsProfile\DefaultProfile::class,
    /** This configuration is used by `DefaultProfile`. */
    'default_profile' => [
        'allow_credentials' => true,
        'allow_origins' => [
            '*',
        ],
        'allow_methods' => [
            'DELETE',
            'GET',
            'OPTIONS',
            'PATCH',
            'POST',
            'PUT',
        ],
        'allow_headers' => [
            'Access-Control-Allow-Credentials',
            'Authorization',
            'Content-Type',
            'Origin',
            'X-Auth-Token',
        ],
        'expose_headers' => [
            'Cache-Control',
            'Content-Language',
            'Content-Type',
            'Expires',
            'Last-Modified',
            'Pragma',
        ],
        'forbidden_response' => [
            'message' => 'Forbidden.',
            'status' => 403,
        ],
        /** Preflight request will respond with value for the max age header. */
        'max_age' => 60 * 60 * 24,
    ],
];
