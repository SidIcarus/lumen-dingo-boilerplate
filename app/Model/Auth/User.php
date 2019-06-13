<?php declare(strict_types=1);

namespace App\Models\Auth\User;

use App\Traits\Hashable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
    implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasApiTokens;
    use HasRoles;
    use SoftDeletes;
    use Hashable;


    const PERMISSIONS = [
        // basic
        'index' => 'user index',
        'create' => 'user store',
        'show' => 'user show',
        'update' => 'user update',
        'destroy' => 'user destroy',
        // deletes
        'deleted list' => 'user deleted list',
        'purge' => 'user purge',
        'restore' => 'user restore',
        // status
//        'update status' => 'user update status',
//        'deactivated list' => 'user deactivated list',
    ];

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'password',
    ];

    /**
     * @inheritDoc
     */
    protected $hidden = [
        'password',
    ];
}
