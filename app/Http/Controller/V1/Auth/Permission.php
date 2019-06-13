<?php declare(strict_types=1);

namespace App\Http\Controllers\V1\Backend\Auth\Permission;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\Permission\PermissionRepository;
use App\Transformers\Auth\PermissionTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PermissionController
 *
 * @package App\Http\Controllers\V1\Backend\Auth\Permission
 */
class PermissionController extends Controller
{
    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * PermissionController constructor.
     *
     * @param \App\Repositories\Auth\Permission\PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $permissions = $permissionRepository->makeModel()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);

        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     *
     * @return Response
     * @api                {get} /auth/permissions Get all permissions
     * @apiName            get-all-permissions
     * @apiGroup           Permission
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             PermissionsResponse
     *
     */
    public function index(Request $request): Response
    {
        $this->permissionRepository->pushCriteria(new RequestCriteria($request));

        return $this->paginatorOrCollection(
            $this->permissionRepository->paginate(),
            new PermissionTransformer()
        );
    }

    /**
     * @param \Dingo\Api\Http\Request $request
     * @param string $id
     *
     * @return Response
     * @api                {get} /auth/permissions/{id} Show permission
     * @apiName            show-permission
     * @apiGroup           Permission
     * @apiVersion         1.0.0
     * @apiPermission      Authenticated User
     * @apiUse             PermissionResponse
     *
     */
    public function show(Request $request, string $id): Response
    {
        $this->permissionRepository->pushCriteria(new RequestCriteria($request));
        $p = $this->permissionRepository->find($this->decodeHash($id));

        return $this->item($p, new PermissionTransformer());
    }
}
