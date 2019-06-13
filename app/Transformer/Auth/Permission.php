<?php declare(strict_types=1);

namespace App\Transformers\Auth;

use App\Models\Auth\Permission\Permission;
use App\Transformers\BaseTransformer;

class PermissionTransformer extends BaseTransformer
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
    ];

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param \App\Models\Auth\Permission\Permission $permission
     *
     * @return array
     */
    public function transform(Permission $permission): array
    {
        return [
            'id' => $permission->getHashedId(),
            'name' => $permission->name,
        ];
    }

    /**
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'permissions';
    }
}
