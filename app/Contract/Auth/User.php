<?php declare(strict_types=1);

namespace App\Repositories\Auth\User;

use App\Repositories\BaseRepositoryInterface;

interface UserRepository extends BaseRepositoryInterface
{

    public function assignRole($id, int $roleId);


    public function givePermissionTo($id, int $permissionId);


    public function removeRole($id, int $roleId);


    public function revokePermissionTo($id, int $permissionId);
}
