<?php declare(strict_types=1);

namespace App\Transformers\Auth;

use App\Models\Auth\User\User;
use App\Transformers\BaseTransformer;

class UserTransformer extends BaseTransformer
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'roles',
        'permissions',
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
     * @param \App\Models\Auth\User\User $user
     *
     * @return array
     */
    public function transform(User $user): array
    {
        $response = [
            'id' => $user->getHashedId(),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ];

        $response = $this->filterData(
            $response,
            [

            ]
        );

        return $this->addTimesHumanReadable($user, $response);
    }

    public function includeRoles(User $user)
    {
        return $this->collection($user->roles, new RoleTransformer());
    }

    public function includePermissions(User $user)
    {
        return $this->collection($user->permissions, new PermissionTransformer());
    }

    /**
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'users';
    }
}
