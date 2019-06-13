<?php declare(strict_types=1);

namespace App\Transformers\Auth;

use App\Models\Auth\Permission\Permission;
use App\Transformers\BaseTransformer;

class PermissionTransformer extends BaseTransformer
{

    protected $availableIncludes = [
    ];


    protected $defaultIncludes = [
    ];


    public function transform(Permission $permission): array
    {
        return [
            'id' => $permission->getHashedId(),
            'name' => $permission->name,
        ];
    }


    public function getResourceKey(): string
    {
        return 'permissions';
    }
}
