<?php declare(strict_types=1);

namespace App\Repositories\Auth\Role;

use App\Repositories\BaseRepositoryInterface;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Interface RoleRepository
 *
 * @package App\Repositories\Auth\Role
 */
interface RoleRepository extends BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @param $id
     *
     * @return mixed
     * @throws RepositoryException
     * @throws ValidatorException
     */
    public function update(array $attributes, $id);

    /**
     * @param $id
     * @param int $permissionId
     */
    public function givePermissionTo($id, int $permissionId);

    /**
     * @param $id
     * @param int $permissionId
     */
    public function revokePermissionTo($id, int $permissionId);
}
