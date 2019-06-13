<?php declare(strict_types=1);

return [

    'models' => [



//        'permission' => Spatie\Permission\Models\Permission::class,
        'permission' => App\Models\Auth\Permission\Permission::class,



//        'role' => Spatie\Permission\Models\Role::class,
        'role' => App\Models\Auth\Role\Role::class,

    ],

    'table_names' => [



        'roles' => 'permissions_roles',



        'permissions' => 'permissions_permissions',



        'model_has_permissions' => 'permissions_model_has_permissions',



        'model_has_roles' => 'permissions_model_has_roles',



        'role_has_permissions' => 'permissions_role_has_permissions',
    ],

    'column_names' => [



        'model_morph_key' => 'model_id',
    ],



    'display_permission_in_exception' => true,

    'cache' => [



        'expiration_time' => \DateInterval::createFromDateString('24 hours'),



        'key' => 'spatie.permission.cache',



        'model_key' => 'name',



        'store' => 'file',
    ],
];
