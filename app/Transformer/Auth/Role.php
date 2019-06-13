<?php declare(strict_types=1);

namespace App\Transformers\Auth;

use App\Models\Auth\Role\Role;
use App\Transformers\BaseTransformer;

class RoleTransformer extends BaseTransformer
{

    protected $availableIncludes = [
    ];


    protected $defaultIncludes = [
        'permissions',
    ];


    public function transform(Role $role): array
    {
        return [
            'id' => $role->getHashedId(),
            'name' => $role->name,
        ];
    }

    public function includePermissions(Role $role)
    {
        return $this->collection($role->permissions, new PermissionTransformer());
    }


    public function getResourceKey(): string
    {
        return 'roles';
    }
}
