<?php declare(strict_types=1);
namespace App\Repositories\Auth\Permission;

use App\Repositories\BaseRepository;

/**
 * Class PermissionRepositoryEloquent
 *
 * @package App\Repositories\Auth\Permission
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return config('permission.models.permission');
    }
}
