<?php declare(strict_types=1);

namespace App\Http\Controllers\V1\Backend\Auth\Permission;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\Permission\PermissionRepository;
use App\Transformers\Auth\PermissionTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;


class PermissionController extends Controller
{

    protected $permissionRepository;


    public function __construct(PermissionRepository $permissionRepository)
    {
        $permissions = $permissionRepository->makeModel()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);

        $this->permissionRepository = $permissionRepository;
    }


    public function index(Request $request): Response
    {
        $this->permissionRepository->pushCriteria(new RequestCriteria($request));

        return $this->paginatorOrCollection(
            $this->permissionRepository->paginate(),
            new PermissionTransformer()
        );
    }


    public function show(Request $request, string $id): Response
    {
        $this->permissionRepository->pushCriteria(new RequestCriteria($request));
        $p = $this->permissionRepository->find($this->decodeHash($id));

        return $this->item($p, new PermissionTransformer());
    }
}
