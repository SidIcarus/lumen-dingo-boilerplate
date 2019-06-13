<?php declare(strict_types=1);

namespace Adventive\Http\Controller\V1\Auth;

use Adventive\Contract\Auth\Role as RoleRepository;
use Adventive\Contract\Auth\User as Repository;
use Adventive\Http\Controller\Base as Controller;
use Adventive\Transformer\Auth\Role as RoleTransformer;
use Adventive\Transformer\Auth\User as Transformer;
use Dingo\Api\Http\{Request, Response};


final class Authorization extends Controller
{

    protected $roleRepository;

    public function __construct(Repository $repository, RoleRepository $roleRepository)
    {
        parent::__construct($repository);

        $this->roleRepository = $roleRepository;

        $permission = config('setting.permission.permission_names.manage_authorization');
        $this->middleware("permission:${permission}");
    }


    public function assignRoleToUser(Request $request): Response
    {
        $id = $this->decodeHash($request->input('user_id'));
        $this->repository->assignRole(
            $id,
            $this->decodeHash($request->input('role_id'))
        );

        return $this->item($this->repository->find($id), new Transformer());
    }


    public function revokeRoleFromUser(Request $request): Response
    {
        $id = $this->decodeHash($request->input('user_id'));
        $this->repository->removeRole(
            $id,
            $this->decodeHash($request->input('role_id'))
        );

        return $this->item($this->repository->find($id), new Transformer());
    }


    public function assignPermissionToUser(Request $request): Response
    {
        $id = $this->decodeHash($request->input('user_id'));
        $this->repository->givePermissionTo(
            $id,
            $this->decodeHash($request->input('permission_id'))
        );

        return $this->item($this->repository->find($id), new Transformer());
    }


    public function revokePermissionFromUser(Request $request): Response
    {
        $id = $this->decodeHash($request->input('user_id'));
        $this->repository->revokePermissionTo(
            $id,
            $this->decodeHash($request->input('permission_id'))
        );

        return $this->item($this->repository->find($id), new Transformer());
    }


    public function attachPermissionToRole(Request $request): Response
    {
        $id = $this->decodeHash($request->input('role_id'));
        $this->roleRepository->givePermissionTo(
            $id,
            $this->decodeHash($request->input('permission_id'))
        );

        return $this->item($this->roleRepository->find($id), new RoleTransformer());
    }


    public function revokePermissionFromRole(Request $request): Response
    {
        $id = $this->decodeHash($request->input('role_id'));
        $this->roleRepository->revokePermissionTo(
            $id,
            $this->decodeHash($request->input('permission_id'))
        );

        return $this->item($this->roleRepository->find($id), new RoleTransformer());
    }
}
