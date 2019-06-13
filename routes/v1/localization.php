<?php declare(strict_types=1);

$api->get(
    '/localizations',
    [
        'uses' => 'LocalizationController@index',
    ]
);
