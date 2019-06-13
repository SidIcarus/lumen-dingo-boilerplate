<?php declare(strict_types=1);

namespace App\Repositories\Auth\User;

use App\Models\Auth\User\User;
use App\Repositories\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

    protected $fieldSearchable = [
        'first_name' => 'like',
        'last_name' => 'like',
        'email' => 'like',
    ];


    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email|unique:users,email',
        ],
    ];


    public function model()
    {
        return User::class;
    }


    public function create(array $attributes)
    {
        $attributes['password'] = app('hash')->make($attributes['password']);

        return parent::create($attributes);
    }


    public function assignRole($id, int $roleId)
    {
        $user = $this->find($id);
        event(new RepositoryEntityUpdated($this, $user->assignRole($roleId)));

        return $user;
    }


    public function givePermissionTo($id, int $permissionId)
    {
        event(
            new RepositoryEntityUpdated(
                $this,
                $this->find($id)->givePermissionTo($permissionId)
            )
        );
    }


    public function removeRole($id, int $roleId)
    {
        $user = $this->find($id);
        $user->removeRole($roleId);
        event(new RepositoryEntityUpdated($this, $user));
    }


    public function revokePermissionTo($id, int $permissionId)
    {
        $user = $this->find($id);
        $user->revokePermissionTo($permissionId);
        event(new RepositoryEntityUpdated($this, $user));
    }
}
