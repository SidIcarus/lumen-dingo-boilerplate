<?php declare(strict_types=1);

namespace App\Repositories\Auth\Role;

use App\Repositories\BaseRepositoryInterface;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;


interface RoleRepository extends BaseRepositoryInterface
{

    public function update(array $attributes, $id);


    public function givePermissionTo($id, int $permissionId);


    public function revokePermissionTo($id, int $permissionId);
}
