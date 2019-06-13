<?php declare(strict_types=1);

namespace App\Repositories\Auth\Permission;

use App\Repositories\BaseRepository;


class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{

    protected $fieldSearchable = [
        'name' => 'like',
    ];


    public function model()
    {
        return config('permission.models.permission');
    }
}
