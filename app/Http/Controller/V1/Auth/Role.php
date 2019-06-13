<?php declare(strict_types=1);


namespace App\Http\Controllers\V1\Backend\Auth\Role;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\Role\RoleRepository;
use App\Transformers\Auth\RoleTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;


class RoleController extends Controller
{

    protected $roleRepository;


    public function __construct(RoleRepository $roleRepository)
    {
        $permissions = $roleRepository->makeModel()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['create'], ['only' => 'store']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);
        $this->middleware('permission:' . $permissions['update'], ['only' => 'update']);
        $this->middleware('permission:' . $permissions['destroy'], ['only' => 'destroy']);

        $this->roleRepository = $roleRepository;
    }


    public function index(Request $request): Response
    {
        $this->roleRepository->pushCriteria(new RequestCriteria($request));

        return $this->paginatorOrCollection(
            $this->roleRepository->paginate(),
            new RoleTransformer()
        );
    }


    public function store(Request $request): Response
    {
        $role = $this->roleRepository->create(
            [
                'name' => $request->input('name'),
            ]
        );

        return $this->item($role, new RoleTransformer())->statusCode(201);
    }


    public function show(Request $request, string $id): Response
    {
        $this->roleRepository->pushCriteria(new RequestCriteria($request));
        $role = $this->roleRepository->find($this->decodeHash($id));

        return $this->item($role, new RoleTransformer());
    }


    public function update(Request $request, string $id): Response
    {
        $role = $this->roleRepository->update(
            [
                'name' => $request->input('name'),
            ],
            $this->decodeHash($id)
        );

        return $this->item($role, new RoleTransformer());
    }


    public function destroy(string $id): Response
    {
        $this->roleRepository->delete($this->decodeHash($id));

        return $this->response->noContent();
    }
}
