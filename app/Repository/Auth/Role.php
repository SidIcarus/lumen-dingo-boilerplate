<?php declare(strict_types=1);


namespace App\Repositories\Auth\Role;

use App\Criterion\Eloquent\ThisWhereEqualsCriteria;
use App\Repositories\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\Permission\Guard;


class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{

    protected $fieldSearchable = [
        'name' => 'like',
    ];


    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string',
        ],
    ];


    public function revokePermissionTo($id, int $permissionId)
    {
        $role = $this->find($id);
        $role->revokePermissionTo($permissionId);
        event(new RepositoryEntityUpdated($this, $role));
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


    public function update(array $attributes, $id)
    {
        $this->skipPresenter(true);

        $role = $this->checkDefault($id);

        $attributes['name'] = $attributes['name'] ?? '';

        $guardName = Guard::getDefaultName($this->model());
        $this->pushCriteria(new ThisWhereEqualsCriteria('name', $attributes['name']));
        $this->pushCriteria(new ThisWhereEqualsCriteria('guard_name', $guardName));
        $checkRole = $this->first();
        if ($checkRole !== null && $role->id != $checkRole->id) {
            abort(
                422,
                "A role `{$attributes['name']}` already exists for guard `$guardName`."
            );
        }

        $this->skipPresenter(false);

        return parent::update($attributes, $id);
    }


    public function model()
    {
        return config('permission.models.role');
    }

    public function delete($id)
    {
        $this->checkDefault($id);

        return parent::delete($id);
    }


    public function create(array $attributes)
    {
        $this->validate($attributes, ValidatorInterface::RULE_CREATE);

        $role = $this->model()::create($attributes);
        event(new RepositoryEntityUpdated($this, $role));

        return $this->parserResult($role);
    }


    private function checkDefault($id)
    {
        $role = $this->find($id);
        if (in_array($role->name, config('setting.permission.role_names'), true)) {
            abort(403, 'You cannot update/delete default role.');
        }

        return $role;
    }

    private function validate(array $attributes, $rule)
    {
        $attributes = $this->model->newInstance()
            ->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
        $this->validator->with($attributes)->passesOrFail($rule);
    }
}
