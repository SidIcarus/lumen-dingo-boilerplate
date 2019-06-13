<?php declare(strict_types=1);
namespace App\Models\Auth\Role;

use App\Traits\Hashable;

class Role extends \Spatie\Permission\Models\Role
{
    use Hashable;

    /**
     * all permissions
     *
     * name => value
     */
    const PERMISSIONS = [
        'index' => 'role index',
        'create' => 'role store',
        'show' => 'role show',
        'update' => 'role update',
        'destroy' => 'role destroy',
    ];
}
