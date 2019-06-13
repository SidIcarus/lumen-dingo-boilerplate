<?php declare(strict_types=1);
namespace App\Repositories\Auth\Role;

use App\Repositories\BaseRepositoryInterface;

/**
 * Interface RoleRepository
 *
 * @package App\Repositories\Auth\Role
 */
interface RoleRepository extends BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id);

    /**
     * @param     $id
     * @param int $permissionId
     */
    public function givePermissionTo($id, int $permissionId);

    /**
     * @param     $id
     * @param int $permissionId
     */
    public function revokePermissionTo($id, int $permissionId);
}
