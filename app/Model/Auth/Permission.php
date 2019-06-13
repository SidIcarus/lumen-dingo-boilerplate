<?php declare(strict_types=1);

namespace App\Models\Auth\Permission;

use App\Traits\Hashable;

class Permission extends \Spatie\Permission\Models\Permission
{
    use Hashable;


    const PERMISSIONS = [
        'index' => 'permission index',
        'show' => 'permission show',
    ];
}
