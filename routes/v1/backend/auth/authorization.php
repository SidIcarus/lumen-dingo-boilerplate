<?php declare(strict_types=1);

$api->group(
    [
        'namespace' => 'Auth\Authorization',
        'as' => 'authorizations',
        'prefix' => 'authorizations',
    ],
    function () use ($api) {
        // role - user
        $api->post(
            '/assign-role-to-user',
            [
                'as' => 'assign-role-to-user',
                'uses' => 'AuthorizationController@assignRoleToUser',
            ]
        );
        $api->post(
            '/revoke-role-from-user',
            [
                'as' => 'revoke-role-from-user',
                'uses' => 'AuthorizationController@revokeRoleFormUser',
            ]
        );

        // permission - user
        $api->post(
            '/assign-permission-to-user',
            [
                'as' => 'assign-permission-to-user',
                'uses' => 'AuthorizationController@assignPermissionToUser',
            ]
        );
        $api->post(
            '/revoke-permission-from-user',
            [
                'as' => 'revoke-permission-from-user',
                'uses' => 'AuthorizationController@revokePermissionFromUser',
            ]
        );

        // permission - role
        $api->post(
            '/attach-permission-to-role',
            [
                'as' => 'attach-permission-to-role',
                'uses' => 'AuthorizationController@attachPermissionToRole',
            ]
        );
        $api->post(
            '/revoke-permission-from-role',
            [
                'as' => 'revoke-permission-from-role',
                'uses' => 'AuthorizationController@revokePermissionFromRole',
            ]
        );
    }
);
